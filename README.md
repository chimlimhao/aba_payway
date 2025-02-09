<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About ABA PayWay

It's a payment gateway that offer seamless experience to both the user and the developer. They offer a pretty easy way to integrate into projects either web/app.

## Integration Process

- Manually create a config file within the ```config``` directory "config/**payway.php**"
- Once created, paste this code into it:

    ```php
    <?php
    // config/payway.php
    return [
        'api_url' => env('ABA_PAYWAY_API_URL'),
        'api_key' => env('ABA_PAYWAY_API_KEY'),
        'merchant_id' => env('ABA_PAYWAY_MERCHANT_ID'),
    ];
    ```
    It's a configuration file that is used to access to the environment variables that contains sensitive information. It's generally used in larger project/production cause of its flexibility, security, management, and cache cleansing.
- Manually create the `Services` directory within the `app` directory and create a new file inside called `PayWayService.php`. It should look something like this "app/**Services/PayWayService.php**".
- Insert these codes in:
    ```php
    <?php
    // app/Services/PayWayService.php
    namespace App\Services;

    class PayWayService
    {
        /**
         * Get the API URL from the configuration.
         *
         * @return string
         */
        public function getApiUrl()
        {
            return config('payway.api_url');
        }

        /**
         * Generate the hash for PayWay security.
         *
         * @param string $str
         * @return string
         */
        public function getHash($str)
        {
            $key = config('payway.api_key');
            return base64_encode(hash_hmac('sha512', $str, $key, true));
        }
    }
    ```
    Creating a service class to manage access to environment variables is a good approach, especially if you want to encapsulate logic related to API calls or configuration management in one place. This can make your codebase cleaner, more modular, and easier to maintain.

- In `Providers` directory, create a file "app/Providers/**AppServiceProvider.php**" and insert these codes in:
    ```php
    <?php
    namespace App\Providers;

    use App\Services\PayWayService;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Register any application services.
         */
        public function register(): void
        {
            $this->app->singleton(PayWayService::class, function ($app) {
                return new PayWayService();
            });
        }

        /**
         * Bootstrap any application services.
         */
        public function boot(): void
        {
            //
        }
    }
    ```
    
## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
