<?php


namespace App\Repository;


use App\Contracts\PageRepositoryInterface;
use App\Models\Page;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PageRepository implements PageRepositoryInterface
{

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
}
