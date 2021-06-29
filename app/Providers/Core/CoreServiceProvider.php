<?php

declare(strict_types=1);

namespace App\Providers\Core;

use App\Infrastructure\Core\BooksCatalog\Author\MySql\DataConverter as DataConverterBookAuthor;
use App\Infrastructure\Core\BooksCatalog\Author\MySql\DataProvider as DataProviderBookAuthor;
use App\Infrastructure\Core\BooksCatalog\Author\MySql\DBGateway as DBGatewayBookAuthor;
use App\Infrastructure\Core\BooksCatalog\Author\MySql\RepoConverter as RepoConverterBookAuthor;
use App\Infrastructure\Core\BooksCatalog\Author\MySql\Repository as RepositoryBookAuthor;
use App\Infrastructure\Core\BooksCatalog\Book\MySql\DataConverter;
use App\Infrastructure\Core\BooksCatalog\Book\MySql\DataProvider as DataProviderBook;
use App\Infrastructure\Core\BooksCatalog\Book\MySql\DBGateway as DBGatewayBook;
use App\Infrastructure\Core\BooksCatalog\Book\MySql\RepoConverter as RepoConverterBook;
use App\Infrastructure\Core\BooksCatalog\Book\MySql\Repository as RepositoryBook;
use App\Infrastructure\Core\Counter\Cache\Cache as CacheCounter;
use App\Infrastructure\Core\Counter\MySql\DBGateway as DBGatewayCounter;
use App\Infrastructure\Core\Counter\MySql\RepoConverter as RepoConverterCounter;
use App\Infrastructure\Core\Counter\MySql\Repository as RepositoryCounter;
use App\Infrastructure\Event\EventsPublisher;
use App\Infrastructure\MySql\DBTransaction;
use Core\BooksCatalog\Author\IDataProvider as IDataProviderBookAuthor;
use Core\BooksCatalog\Author\IDBGateway as IDBGatewayBookAuthor;
use Core\BooksCatalog\Author\IRepository as IRepositoryBookAuthor;
use Core\BooksCatalog\Book\IDataProvider as IDataProviderBook;
use Core\BooksCatalog\Book\IDBGateway as IDBGatewayBook;
use Core\BooksCatalog\Book\IRepository as IRepositoryBook;
use Core\Common\Action\IDBTransaction;
use Core\Common\Event\IEventsPublisher;
use Core\Counter\ICache as ICacheCounter;
use Core\Counter\IDBGateway as IDBGatewayCounter;
use Core\Counter\IRepository as IRepositoryCounter;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, string>
     */
    public array $singletons = [
        // Event
        IEventsPublisher::class => EventsPublisher::class,

        // Infrastructure
        IDBTransaction::class => DBTransaction::class,

        // BookAuthor
        RepoConverterBookAuthor::class => RepoConverterBookAuthor::class,
        IRepositoryBookAuthor::class => RepositoryBookAuthor::class,
        DataConverterBookAuthor::class => DataConverterBookAuthor::class,
        IDataProviderBookAuthor::class => DataProviderBookAuthor::class,
        IDBGatewayBookAuthor::class => DBGatewayBookAuthor::class,

        // Book
        RepoConverterBook::class => RepoConverterBook::class,
        IRepositoryBook::class => RepositoryBook::class,
        DataConverter::class => DataConverter::class,
        IDataProviderBook::class => DataProviderBook::class,
        IDBGatewayBook::class => DBGatewayBook::class,

        // Banner
        RepoConverterCounter::class => RepoConverterCounter::class,
        IRepositoryCounter::class => RepositoryCounter::class,
        IDBGatewayCounter::class => DBGatewayCounter::class,
        ICacheCounter::class => CacheCounter::class,
    ];
}
