<?php


namespace App\Repository;


use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Create new user
     * @param Request $request
     * @return User
     */
    public function create(Request $request): User
    {
        $user             = new User();
        $user->uuid       = Uuid::uuid4()->toString();
        $user->first_name = $request->input('first_name');
        $user->last_name  = $request->input('last_name');
        $user->email      = $request->input('email');
        $user->password   = $request->input('password');
        $user->save();

        return $user;
    }


    /**
     * @param string $id
     * @return User
     */
    public function find(string $id): User
    {
        return $this->user->where('uuid', $id)->first();
    }


    /**
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): User
    {
        return $this->user->where('email', $email)->first();
    }
}
