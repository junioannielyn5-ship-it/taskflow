<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Modules\Identity\Models\User;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\ProjectMember;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);

        $project = Project::query()->orderBy('id')->first();

        if (! $project) {
            $project = Project::query()->create([
                'name' => 'Getting Started Project',
                'description' => 'Default project for new users',
                'status' => 'pending_request',
                'created_by' => $user->id,
            ]);
        }

        if ($project) {
            ProjectMember::query()->updateOrCreate(
                [
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                ],
                ['role' => $project->created_by === $user->id ? 'lead' : 'member']
            );
        }

        return $user;
    }
}
