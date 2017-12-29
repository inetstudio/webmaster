@extends('admin::back.layouts.app')

@php
    $title = 'Webmaster';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.webmaster::back.partials.breadcrumbs')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form class="form-horizontal">

                            {!! Form::string('id', $config['id'], [
                                'label' => [
                                    'title' => 'ID приложения',
                                ],
                                'field' => [
                                    'class' => 'form-control',
                                    'disabled' => true,
                                ],
                            ]) !!}

                            {!! Form::string('secret', $config['secret'], [
                                'label' => [
                                    'title' => 'Пароль',
                                ],
                                'field' => [
                                    'class' => 'form-control',
                                    'disabled' => true,
                                ],
                            ]) !!}

                            {!! Form::string('callback_url', $config['callback_url'], [
                                'label' => [
                                    'title' => 'Callback URL',
                                ],
                                'field' => [
                                    'class' => 'form-control',
                                    'disabled' => true,
                                ],
                            ]) !!}

                            {!! Form::string('token', $config['token'], [
                                'label' => [
                                    'title' => 'Token',
                                ],
                                'field' => [
                                    'class' => 'form-control',
                                    'disabled' => true,
                                ],
                            ]) !!}

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <a href="{{ ($config['id']) ? 'https://oauth.yandex.ru/client/'.$config['id'] : 'https://oauth.yandex.ru/client/new' }}"
                                       target="_blank"
                                       class="btn btn-w-m btn-default m-l-xs">{{ ($config['id']) ? 'Редактировать приложение' : 'Создать приложение' }}</a>

                                    @if ($config['id'])
                                        <a href="https://oauth.yandex.ru/authorize?response_type=code&client_id={{ $config['id'] }}" class="btn btn-w-m btn-primary m-l-xs">Получить token</a>
                                    @endif
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushonce('scripts:webmaster')
    @if (session()->has('webmaster_access'))
        <script>
            $(document).ready(function () {
                swal({
                    title: "YANDEX_WEBMASTER_TOKEN",
                    text: "Сохраните токен {{ session()->get('webmaster_access.token') }} в .env",
                    type: "success"
                });
            })
        </script>
    @endif
@endpushonce
