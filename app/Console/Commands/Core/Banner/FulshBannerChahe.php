<?php /** @noinspection ALL */

declare(strict_types=1);

namespace App\Console\Commands\Core\Banner;

use Core\Counter\Actions\FlushCache;
use Demo\Core\Context\Infrastructure\Cache\Storage\RedisCacheStorage;
use Demo\Core\Context\Infrastructure\Mysql\Storage\MysqlStorage;
use Illuminate\Console\Command;

class FulshBannerChahe extends Command
{
    /**
     * @var string
     */
    protected $signature = 'banner:flush-cache';

    /**
     * @var string
     */
    protected $description = 'Сохранение кеша баннера в БД.';

    private FlushCache $flushCache;

    public function __construct(FlushCache $flushCache)
    {
        parent::__construct();
        $this->flushCache = $flushCache;
    }

    public function handle(): int
    {
        $this->flushCache->execute('banner');

        return 0;
    }
}
