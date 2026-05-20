<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Modules\Admin\Models\AdminAuditLog;
use App\Modules\Admin\Models\SystemSetting;
use App\Modules\Admin\Models\TaskCompany;
use App\Modules\Admin\Models\TaskProcessOption;
use App\Modules\Admin\Models\TaskTeamOption;
use App\Modules\Identity\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminConfigurationController
{
    public function index()
    {
        $this->authorizeManager();

        return view('admin.configuration', [
            'companies' => TaskCompany::query()->orderBy('name')->get(),
            'processes' => TaskProcessOption::query()->orderBy('name')->get(),
            'teams' => TaskTeamOption::query()->orderBy('name')->get(),
            'announcement' => SystemSetting::valueOf('system_announcement', ''),
            'dailyReportRecipients' => SystemSetting::valueOf('daily_report_recipients', ''),
            'personalAlertEmail' => SystemSetting::valueOf('personal_alert_email', ''),
            'deadlineAlertBcc' => SystemSetting::valueOf('deadline_alert_bcc', ''),
        ]);
    }

    public function storeCompany(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:task_companies,name'],
        ]);

        $company = TaskCompany::query()->create([
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        $this->logClientActivity('created', $company->name);

        return back()->with('success', 'Company/Client added.');
    }

    public function deleteCompany(TaskCompany $company): RedirectResponse
    {
        $this->authorizeManager();

        $name = $company->name;
        $company->delete();

        $this->logClientActivity('deleted', $name);

        return back()->with('success', 'Company/Client deleted.');
    }

    public function updateCompany(Request $request, TaskCompany $company): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:task_companies,name,'.$company->id],
        ]);

        $oldName = $company->name;
        $company->update([
            'name' => $validated['name'],
        ]);

        if ($oldName !== $company->name) {
            $this->logClientActivity('updated', $company->name);
        }

        return back()->with('success', 'Company/Client updated.');
    }

    public function storeProcess(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:task_process_options,name'],
        ]);

        TaskProcessOption::query()->create([
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Task Process label added.');
    }

    public function deleteProcess(TaskProcessOption $process): RedirectResponse
    {
        $this->authorizeManager();

        $process->delete();

        return back()->with('success', 'Task Process label deleted.');
    }

    public function updateProcess(Request $request, TaskProcessOption $process): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:task_process_options,name,'.$process->id],
        ]);

        $process->update([
            'name' => $validated['name'],
        ]);

        return back()->with('success', 'Task Process label updated.');
    }

    public function storeTeam(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:task_team_options,name'],
        ]);

        TaskTeamOption::query()->create([
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Team-in-charge label added.');
    }

    public function deleteTeam(TaskTeamOption $team): RedirectResponse
    {
        $this->authorizeManager();

        $team->delete();

        return back()->with('success', 'Team-in-charge label deleted.');
    }

    public function updateTeam(Request $request, TaskTeamOption $team): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:task_team_options,name,'.$team->id],
        ]);

        $team->update([
            'name' => $validated['name'],
        ]);

        return back()->with('success', 'Team-in-charge label updated.');
    }

    public function updateAnnouncement(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'announcement' => ['nullable', 'string', 'max:2000'],
            'daily_report_recipients' => ['nullable', 'string', 'max:2000'],
            'personal_alert_email' => ['nullable', 'email', 'max:255'],
            'deadline_alert_bcc' => ['nullable', 'email', 'max:255'],
        ]);

        SystemSetting::setValue('system_announcement', $validated['announcement'] ?? '');
        SystemSetting::setValue('daily_report_recipients', $validated['daily_report_recipients'] ?? '');
        SystemSetting::setValue('personal_alert_email', $validated['personal_alert_email'] ?? '');
        SystemSetting::setValue('deadline_alert_bcc', $validated['deadline_alert_bcc'] ?? '');

        return back()->with('success', 'System settings updated.');
    }

    /**
     * Upload and update the company logo.
     */
    public function uploadLogo(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $request->validate([
            'logo' => ['required', 'image', 'max:2048'],
        ]);

        $logoFile = $request->file('logo');
        $logoPath = $logoFile->store('branding', 'public');

        // Save logo path to SystemSetting or config
        SystemSetting::updateOrCreate(
            ['key' => 'branding_logo_path'],
            ['value' => $logoPath]
        );

        return back()->with('success', 'Logo updated successfully!');
    }

    private function authorizeManager(): void
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user || !($user instanceof User)) {
            abort(403, 'Forbidden');
        }

        $allowed = $user->hasAnyRole(['manager', 'project_manager', 'pm', 'admin', 'member', 'technical'])
            || in_array((string) data_get($user, 'role', ''), ['manager', 'project_manager', 'pm', 'admin', 'member', 'technical'], true);

        if (!$allowed) {
            abort(403, 'Forbidden');
        }
    }

    private function logClientActivity(string $action, string $clientName): void
    {
        $actor = Auth::user();

        if (!$actor) {
            return;
        }

        AdminAuditLog::query()->create([
            'admin_id' => $actor->id,
            'action' => 'client_'.$action,
            'details' => [
                'client_name' => $clientName,
                'module' => 'admin_configuration',
                'entity' => 'company_client',
            ],
            'ip_address' => request()->ip(),
        ]);
    }
}
