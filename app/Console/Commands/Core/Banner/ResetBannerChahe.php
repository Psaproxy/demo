<?php /** @noinspection ALL */

declare(strict_types=1);

namespace App\Console\Commands\Core\Banner;

use Core\Counter\Actions\ResetCache;
use Demo\Core\Context\Infrastructure\Cache\Storage\RedisCacheStorage;
use Demo\Core\Context\Infrastructure\Mysql\Storage\MysqlStorage;
use Illuminate\Console\Command;

class ResetBannerChahe extends Command
{
    /**
     * @var string
     */
    protected $signature = 'banner:reset-cache';

    /**
     * @var string
     */
    protected $description = 'Сброс кеша баннера.';

    private ResetCache $resetCache;

    public function __construct(ResetCache $resetCache)
    {
        parent::__construct();
        $this->resetCache = $resetCache;
    }

    public function handle(): int
    {
        $this->resetCache->execute('banner');

        return 0;
    }
}
