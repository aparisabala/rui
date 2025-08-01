<?php

namespace App\Providers;

use App\Repositories\Admin\Systemsettings\SystemUser\ISystemUserRepository;
use App\Repositories\Admin\Systemsettings\SystemUser\SystemUserRepository;
use App\Repositories\BaseRepository;
use App\Repositories\IBaseRepository;
use Illuminate\Support\ServiceProvider;
//use
use App\Repositories\Admin\SuperAdmin\Associates\LibAssociateRepository;
use App\Repositories\Admin\SuperAdmin\Associates\ILibAssociateRepository;

use App\Repositories\Admin\Services\Legal\LegalServiceRepository;
use App\Repositories\Admin\Services\Legal\ILegalServiceRepository;


class RepositoryServiceProvider extends ServiceProvider
{
        /**
         * Register any application services.
         */
        public function register(): void
        {
                $this->app->bind(abstract: IBaseRepository::class, concrete: BaseRepository::class);
                //bind

                $this->app->bind(abstract: ISystemUserRepository::class, concrete: SystemUserRepository::class);
        }
}
