<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class ArticleTopic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'article_id', 'topic_id', 'created_at', 'updated_at'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_article_topic';

}
