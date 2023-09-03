<?php

class PostsController extends Controller
{
    public function index(PostsRepositoryInterface $postsRepo) {
        return $postsRepo->get();
    }
}

interface PostsRepositoryInterface 
{
    public function get();
    public function find(int $id);
}

class PostsRepository implements PostsRepositoryInterface
{
    protected $model;

    public function __construct(Post $model) {
        $this->model = $model;
    }

    public function get() {
        return $this->model->published()->get();
    }

    public function find(int $id) {
        return $this->model->published()->find($id);
    }
}

// 不使用繼承
class PostsCacheRepository implements PostsRepositoryInterface
{
    protected $repo;
    protected $cache;
    const TTL = 1440; # 1 day

    public function __construct(CacheManager $cache, PostsRepository $repo) {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    public function get() {
        return $this->cache->remember('posts', self::TTL, function () {
            return $this->repo->get();
        });
    }

    public function find(int $id) {
        return $this->cache->remember('posts.'.$id, self::TTL, function () {
            return $this->repo->find($id);
        });
    }
}

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // $this->app->bind(PostsRepositoryInterface::class, PostsRepository::class);
        // $this->app->bind(PostsRepositoryInterface::class, PostsCacheRepository::class);
    }
}

