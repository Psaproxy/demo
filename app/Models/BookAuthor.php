<?php /** @noinspection SpellCheckingInspection */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static self create(array $values)
 * @method static self forceCreate(array $values)
 * @method static self|null where(\Closure|string|array|\Illuminate\Database\Query\Expression $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static self|null whereEmail(string $email)
 * @method static bool saveOrFail(array $values = [])
 * @method static self findOrFail($id, $columns = ['*'])
 * @method static self[] all($columns = ['*'])
 * @property string id
 * @property string name
 * @property \DateTimeImmutable created_at
 * @property \DateTimeImmutable updated_at
 */
class BookAuthor extends Model
{
    protected $table = 'books_authors';

    public $incrementing = false;

    protected $keyType = 'string';

    // Не используется в виду того,
    // что все изменения через репозиторий или dbal с полным контролем обновляемых полей.
    //protected $fillable = [];
}
