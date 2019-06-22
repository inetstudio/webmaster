<?php

namespace InetStudio\WebmasterPackage\Webmaster\Services\Back;

use Exception;
use Illuminate\Http\Request;
use hardworm\webmaster\api\webmasterApi;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Services\Back\WebmasterServiceContract;

/**
 * Class WebmasterService.
 */
class WebmasterService implements WebmasterServiceContract
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var webmasterApi
     */
    protected $webmaster;

    /**
     * WebmasterService constructor.
     */
    public function __construct()
    {
        $this->config = config('services.yandex.webmaster');

        try {
            $this->webmaster = webmasterApi::initApi($this->config['token']);
        } catch (Exception $e) {
        }

        if ($this->webmaster) {
            $this->webmaster->triggerError = false;

            $hostsObj = $this->webmaster->getHosts();

            foreach ($hostsObj->hosts as $host) {
                if (trim($host->unicode_host_url, '/') == trim(config('app.url'), '/')) {
                    $this->config['host_id'] = $host->host_id;
                }
            }
        }
    }

    /**
     * Получаем конфигурацию Webmaster'a.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Получаем токен доступа.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function getToken(Request $request): array
    {
        $code = $request->get('code');

        $response = webmasterApi::getAccessToken($code, $this->config['id'], $this->config['secret']);

        return [
            'success' => (! isset($response->error)),
            'token' => $response->access_token ?? null,
            'message' => $response->error_description ?? 'Токен успешно получен',
        ];
    }

    /**
     * Отправляем текст в webmaster, если его там еще нет.
     *
     * @param $object
     */
    public function sendToWebmaster($object): void
    {
        if (! $this->webmaster) {
            return;
        }

        $offset = 0;
        $originalTextsIDs = [];
        $stop = false;

        while (! $stop) {
            $textsResponse = $this->webmaster->getOriginalTexts($this->config['host_id'], $offset);

            if (empty($textsResponse->error_code) && (is_array($textsResponse->original_texts) && ! empty($textsResponse->original_texts))) {
                $originalTextsIDs = array_merge(
                    $originalTextsIDs,
                    array_column($textsResponse->original_texts, 'id')
                );

                $offset += 100;
            } else {
                $stop = true;
            }
        }

        if (! in_array($object->webmaster_id, $originalTextsIDs)) {
            $sendResult = $this->getSendOriginalText(
                $this->fixBadText(
                    trim(html_entity_decode(strip_tags($object->content)))
                )
            );

            if ($sendResult && ! empty($sendResult) && ! empty($sendResult->text_id)) {
                $object->update(
                    [
                        'webmaster_id' => $sendResult->text_id,
                    ]
                );
            }
        }
    }

    /**
     * Добавляем текст в webmaster.
     *
     * @param  null  $content
     *
     * @return mixed
     */
    protected function getSendOriginalText($content = null)
    {
        if (empty($content) || (iconv_strlen($content) < 500) || (iconv_strlen($content) > 32000)) {
            return;
        }

        $addResult = $this->webmaster->addOriginalText($this->config['host_id'], $content);

        if (isset($addResult->error_code) || ! isset($addResult->text_id)) {
            return;
        }

        return $addResult;
    }

    /**
     * Вырезаем из текста битые символы.
     *
     * @param $text
     *
     * @return null|string|string[]
     */
    protected function fixBadText($text): ?string
    {
        return preg_replace('/[\x00-\x1F\x7F]/', ' ', $text);
    }
}
