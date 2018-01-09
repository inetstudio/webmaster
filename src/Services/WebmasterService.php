<?php

namespace InetStudio\Webmaster\Services;

use Illuminate\Http\Request;
use InetStudio\Webmaster\Libraries\Webmaster\webmasterApi;
use InetStudio\Webmaster\Contracts\Services\WebmasterServiceContract;

/**
 * Class WebmasterService
 * @package InetStudio\Webmaster\Services
 */
class WebmasterService implements WebmasterServiceContract
{
    private $config = [];
    private $webmaster;

    /**
     * WebmasterService constructor.
     */
    public function __construct()
    {
        $this->config = [
            'id' => config('services.yandex.webmaster.id'),
            'secret' => config('services.yandex.webmaster.secret'),
            'token' => config('services.yandex.webmaster.token'),
            'callback_url' => config('services.yandex.webmaster.callback_url'),
        ];

        try {
            $this->webmaster = webmasterApi::initApi($this->config['token']);
        } catch (\Exception $e) {

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
     * @param Request $request
     *
     * @return array
     */
    public function getToken(Request $request): array
    {
        $code = $request->get('code');

        $response = webmasterApi::getAccessToken($code, $this->config['id'], $this->config['secret']);

        return [
            'success' => (isset($response->error)) ? false : true,
            'token' => (isset($response->access_token)) ? $response->access_token : null,
            'message' => (isset($response->error)) ? $response->error_description : 'Токен успешно получен',
        ];
    }

    /**
     * Отправляем текст в webmaster, если его там еще нет.
     *
     * @param $object
     */
    public function sendToWebmaster($object): void
    {
        if ($this->webmaster) {

            $offset = 0;
            $originalTextsIDs = [];
            $stop = false;

            while (! $stop) {
                $textsResponse = $this->webmaster->getOriginalTexts($this->config['host_id'], $offset);

                if (empty($textsResponse->error_code) && (is_array($textsResponse->original_texts) && ! empty($textsResponse->original_texts))) {
                    $originalTextsIDs = array_merge($originalTextsIDs, array_column($textsResponse->original_texts, 'id'));

                    $offset += 100;
                } else {
                    $stop = true;
                }
            }

            if (! in_array($object->webmaster_id, $originalTextsIDs)) {

                $sendResult = $this->getSendOriginalText(trim(html_entity_decode(strip_tags($object->content))));

                if (! empty($sendResult) && ($sendResult != false) && ! empty($sendResult->text_id)) {
                    $object->update([
                        'webmaster_id' => $sendResult->text_id,
                    ]);
                }
            }
        }
    }

    /**
     * Добавляем текст в webmaster.
     *
     * @param null $content
     *
     * @return mixed
     */
    private function getSendOriginalText($content = null)
    {
        if (empty($content) || (iconv_strlen($content) < 500) || (iconv_strlen($content) > 32000)) {
            return false;
        }

        $addResult = $this->webmaster->addOriginalText($this->config['host_id'], $content);

        if (isset($addResult->error_code) || ! isset($addResult->text_id)) {
            return false;
        } else {
            return $addResult;
        }
    }
}
