<?php

declare(strict_types=1);

namespace App\Providers\Core;

use App\Infrastructure\Event\EventsPublisher;
use App\Infrastructure\MySql\DBTransaction;
use App\Infrastructure\MySql\Repository\BooksCatalog\Author\DataConverter as DataConverterBookAuthor;
use App\Infrastructure\MySql\Repository\BooksCatalog\Author\DataProvider as DataProviderBookAuthor;
use App\Infrastructure\MySql\Repository\BooksCatalog\Author\DBGateway as DBGatewayBookAuthor;
use App\Infrastructure\MySql\Repository\BooksCatalog\Author\RepoConverter as RepoConverterBookAuthor;
use App\Infrastructure\MySql\Repository\BooksCatalog\Author\Repository as RepositoryBookAuthor;
use App\Infrastructure\MySql\Repository\BooksCatalog\Book\DataConverter;
use App\Infrastructure\MySql\Repository\BooksCatalog\Book\DataProvider as DataProviderBook;
use App\Infrastructure\MySql\Repository\BooksCatalog\Book\DBGateway as DBGatewayBook;
use App\Infrastructure\MySql\Repository\BooksCatalog\Book\RepoConverter as RepoConverterBook;
use App\Infrastructure\MySql\Repository\BooksCatalog\Book\Repository as RepositoryBook;
use Core\BooksCatalog\Author\IDataProvider as IDataProviderBookAuthor;
use Core\BooksCatalog\Author\IDBGateway as IDBGatewayBookAuthor;
use Core\BooksCatalog\Author\IRepository as IRepositoryBookAuthor;
use Core\BooksCatalog\Book\IDataProvider as IDataProviderBook;
use Core\BooksCatalog\Book\IDBGateway as IDBGatewayBook;
use Core\BooksCatalog\Book\IRepository as IRepositoryBook;
use Core\Common\Action\IDBTransaction;
use Core\Common\Event\IEventsPublisher;
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
    ];
}
