<?php


namespace App\Repository;


use App\Contracts\PageRepositoryInterface;
use App\Models\Page;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PageRepository implements PageRepositoryInterface
{

    /**
     * @var Page
     */
    private $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * @param Request $request
     * @param string $user_id
     * @return Page
     */
    public function create(Request $request, string $user_id): Page
    {
        $page          = new Page();
        $page->uuid    = Uuid::uuid4()->toString();
        $page->user_id = $user_id;
        $page->name    = $request->input('name');
        $page->save();

        return $page;
    }


    /**
     * @param string $id
     * @return bool
     */
    public function exist(string $id): bool
    {
        return $this->page->where('uuid', $id)->exists();
    }
}
