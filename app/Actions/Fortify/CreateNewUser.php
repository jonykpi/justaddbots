<?php

namespace App\Actions\Fortify;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Wallo\FilamentCompanies\FilamentCompanies;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => FilamentCompanies::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'plan_id' => 1,
                'password' => Hash::make($input['password']),
            ]), function (User $user) {
                $this->createCompany($user);
            });
        });
    }

    /**
     * Create a personal company for the user.
     */
    protected function createCompany(User $user): void
    {
       $com =  Company::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Company",
            'personal_company' => true,
        ]);
        $user->ownedCompanies()->save($com);
        if (empty($user->current_company_id)){
            $user->current_company_id = $com->id;
            $user->save();
        }
    }
}
