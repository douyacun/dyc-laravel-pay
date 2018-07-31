<?php

namespace DYC\LaravelPay;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use DYC\Pay\Pay;

class PayServiceProvider extends ServiceProvider
{
    /**
     * Determin is defer.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service.
     *
     * @author yansongda <me@yansongda.cn>
     */
    public function boot()
    {
		$this->publishes([
			dirname(__DIR__).'/config/pay.php' => config_path('pay.php')
		]);
    }

    /**
     * Regist the service.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/config/pay.php', 'pay');

        $this->app->singleton('pay.alipay', function () {
            return Pay::alipay(config('pay.alipay'));
        });
        $this->app->singleton('pay.wechat', function () {
            return Pay::wechat(config('pay.wechat'));
        });
    }

    /**
     * Get services.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return array
     */
    public function provides()
    {
        return ['pay.alipay', 'pay.wechat'];
    }
}
