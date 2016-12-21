@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Create Group
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-sm-12">
        <form method="POST" action="{{ route('sentinel.groups.store') }}" accept-charset="UTF-8">

            <h2>Create New Group</h2>

            <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="Name" name="name" type="text"  value="{{ Input::old('email') }}">
                {{ ($errors->has('name') ? $errors->first('name') : '') }}
            </div>

            <label for="Permissions">Permissions</label>
            <div class="form-group">
                <?php $defaultPermissions = config('sentinel.default_permissions', []); ?>
                @foreach ($defaultPermissions as $permission)
                    <label class="checkbox-inline">
                        <input name="permissions[{{ $permission }}]" value="1" type="checkbox"
                        @if (Input::old('permissions[' . $permission .']'))
                           checked
                        @endif        
                        > {{ ucwords($permission) }}
                    </label>
                @endforeach

                 <!-- Custom Permissions -->
                <label class="checkbox-inline ">
                    <input name="permissions[admin]" value="1" type="checkbox" <?php echo e((isset($permissions['admin']) ? 'checked' : '')); ?>>
                    Admin
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[manage_flocks]" value="1" type="checkbox" <?php echo e((isset($permissions['manage_flocks']) ? 'checked' : '')); ?>>
                    Manage Flocks
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[add_users]" value="1" type="checkbox" <?php echo e((isset($permissions['add_users']) ? 'checked' : '')); ?>>
                    Add Users
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[manage_feed_standards]" value="1" type="checkbox" <?php echo e((isset($permissions['manage_feed_standards']) ? 'checked' : '')); ?>>
                    Manage Standards
                </label>
                <label class="checkbox-inline ">
                    <input name="permissions[manage_titers]" value="1" type="checkbox" <?php echo e((isset($permissions['manage_titers']) ? 'checked' : '')); ?>>
                    Manage Titers
                </label>
                <label class="checkbox-inline ">
                    <input name="permissions[manage_vaccines]" value="1" type="checkbox" <?php echo e((isset($permissions['manage_vaccines']) ? 'checked' : '')); ?>>
                    Manage Vaccines
                </label>
                <label class="checkbox-inline ">
                    <input name="permissions[manage_mortalities]" value="1" type="checkbox" <?php echo e((isset($permissions['manage_mortalities']) ? 'checked' : '')); ?>>
                    Manage Mortalities
                </label>
                <!--  <label class="checkbox-inline">
                    <input name="permissions[add_vaccination_detail]" value="1" type="checkbox" <?php echo e((isset($permissions['add_vaccination_detail']) ? 'checked' : '')); ?>>
                    Add Vaccination Details
                </label> 
                <label class="checkbox-inline">
                    <input name="permissions[manage_titers]" value="1" type="checkbox" <?php echo e((isset($permissions['titers']) ? 'checked' : '')); ?>>
                    Titers Monitoring
                </label>-->
                
                <label class="checkbox-inline ">
                    <input name="permissions[add_daily_feed]" value="1" type="checkbox" <?php echo e((isset($permissions['add_daily_feed']) ? 'checked' : '')); ?>>
                    Manage Daily Records
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[weekly_data]" value="1" type="checkbox" <?php echo e((isset($permissions['weekly_data']) ? 'checked' : '')); ?>>
                    Manage Weekly Records
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[add_periodical_reports]" value="1" type="checkbox" <?php echo e((isset($permissions['add_periodical_reports']) ? 'checked' : '')); ?>>
                    Manage Periodical Reports
                </label>
                
                <label class="checkbox-inline ">
                    <input name="permissions[monthly_data]" value="1" type="checkbox" <?php echo e((isset($permissions['monthly_data']) ? 'checked' : '')); ?>>
                    Manage Monthly Recods
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[flock_vaccination]" value="1" type="checkbox" <?php echo e((isset($permissions['flock_vaccination']) ? 'checked' : '')); ?>>
                    Flock Vaccination Details
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[comparison_reports]" value="1" type="checkbox" <?php echo e((isset($permissions['comparison_reports']) ? 'checked' : '')); ?>>
                    Flock Comparisons
                </label>
                
                <label class="checkbox-inline ">
                    <input name="permissions[performance_reports]" value="1" type="checkbox" <?php echo e((isset($permissions['performance_reports']) ? 'checked' : '')); ?>>
                    Performance Reports
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[daily_reports]" value="1" type="checkbox" <?php echo e((isset($permissions['daily_reports']) ? 'checked' : '')); ?>>
                    Daily Performance Reports
                </label>
                
                <label class="checkbox-inline ">
                    <input name="permissions[weekly_reports]" value="1" type="checkbox" <?php echo e((isset($permissions['weekly_reports']) ? 'checked' : '')); ?>>
                    Weekly Performance Reports
                </label>
                
                <label class="checkbox-inline ">
                    <input name="permissions[blood_titers]" value="1" type="checkbox" <?php echo e((isset($permissions['blood_titers']) ? 'checked' : '')); ?>>
                    Monthly Performance Reports
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[periodical_reports]" value="1" type="checkbox" <?php echo e((isset($permissions['periodical_reports']) ? 'checked' : '')); ?>>
                    Periodical Performance Reports
                </label>

                <label class="checkbox-inline ">
                    <input name="permissions[dashboard]" value="1" type="checkbox" <?php echo e((isset($permissions['dashboard']) ? 'checked' : '')); ?>>
                    Dashboard
                </label>

            </div>

            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <input class="btn btn-primary pull-right" value="Create New Group" type="submit">

        </form>

    </div>
</div>

@stop