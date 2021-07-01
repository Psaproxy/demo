<?php

declare(strict_types=1);

namespace App\Providers\Core;

use App\Infrastructure\Event\EventsPublisher;
use App\Infrastructure\Storage\BooksCatalog\Author\DataConverter as DataConverterBookAuthor;
use App\Infrastructure\Storage\BooksCatalog\Author\DataProvider as DataProviderBookAuthor;
use App\Infrastructure\Storage\BooksCatalog\Author\DBGateway as DBGatewayBookAuthor;
use App\Infrastructure\Storage\BooksCatalog\Author\RepoConverter as RepoConverterBookAuthor;
use App\Infrastructure\Storage\BooksCatalog\Author\Repository as RepositoryBookAuthor;
use App\Infrastructure\Storage\BooksCatalog\Book\DataConverter;
use App\Infrastructure\Storage\BooksCatalog\Book\DataProvider as DataProviderBook;
use App\Infrastructure\Storage\BooksCatalog\Book\DBGateway as DBGatewayBook;
use App\Infrastructure\Storage\BooksCatalog\Book\RepoConverter as RepoConverterBook;
use App\Infrastructure\Storage\BooksCatalog\Book\Repository as RepositoryBook;
use App\Infrastructure\Storage\Counter\Cache as CacheCounter;
use App\Infrastructure\Storage\Counter\DBGateway as DBGatewayCounter;
use App\Infrastructure\Storage\Counter\RepoConverter as RepoConverterCounter;
use App\Infrastructure\Storage\Counter\Repository as RepositoryCounter;
use App\Infrastructure\Storage\DBTransaction;
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
