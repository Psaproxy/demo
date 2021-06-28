<?php /** @noinspection ALL */

declare(strict_types=1);

namespace App\Console\Commands\App;

use Demo\Core\Context\Infrastructure\Cache\Storage\RedisCacheStorage;
use Demo\Core\Context\Infrastructure\Mysql\Storage\MysqlStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class TestApp extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * @var string
     */
    protected $description = 'Общий тест работоспособности приложения';

    public function handle(): int
    {
        $this->newLine();
        $this->alert(sprintf('Общий тест приложения "%s"', getenv('APP_NAME')));

        $this->testMysqlConnection();
        $this->newLine();

        $this->testRedisCacheConnection();
        $this->newLine();

        return 0;
    }

    private function testMysqlConnection(): void
    {
        $this->comment('Тест подключения к MySQL');

        $response = DB::selectOne('select version() as version');

        $this->info('[OK] версия: '.$response->version);
    }

    private function testRedisCacheConnection(): void
    {
        $this->comment('Тест подключения к Redis Cache');

        /** @var array<string,string|int> $response */
        $response = Redis::connection()->client()->info();

        $this->info('[OK] версия: '.$response['redis_version']);
    }
}
