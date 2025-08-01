<?php
namespace App\Traits\PxTraits\Commands;

use App\Traits\PxTraits\Commands\PxCrud\CrudControllers;
use App\Traits\PxTraits\Commands\PxCrud\CrudJsAsset;
use App\Traits\PxTraits\Commands\PxCrud\CrudRepository;
use App\Traits\PxTraits\Commands\PxCrud\CrudRequest;
use App\Traits\PxTraits\Commands\PxCrud\CrudRoute;
use App\Traits\PxTraits\Commands\PxCrud\CrudViews;
use App\Traits\PxTraits\Commands\PxCrud\ModelMigration;
use App\Traits\PxTraits\Commands\PxDataTable\DtCreateController;
use App\Traits\PxTraits\Commands\PxDataTable\DtCreateJsAsset;
use App\Traits\PxTraits\Commands\PxDataTable\DtCreateRepository;
use App\Traits\PxTraits\Commands\PxDataTable\DtCreateRoute;
use App\Traits\PxTraits\Commands\PxDataTable\DtCreateViews;
use App\Traits\PxTraits\Commands\PxDataView\DataViewCreateController;
use App\Traits\PxTraits\Commands\PxDataView\DataViewCreateRoute;
use App\Traits\PxTraits\Commands\PxDataView\DataViewCreateViews;
use App\Traits\PxTraits\Commands\PxForm\FormCreateController;
use App\Traits\PxTraits\Commands\PxForm\FormCreateJsAsset;
use App\Traits\PxTraits\Commands\PxForm\FormCreateRepositoy;
use App\Traits\PxTraits\Commands\PxForm\FormCreateRequest;
use App\Traits\PxTraits\Commands\PxForm\FormCreateRoute;
use App\Traits\PxTraits\Commands\PxForm\FormCreateViews;
use App\Traits\PxTraits\Commands\PxLoadView\LoadViewController;
use App\Traits\PxTraits\Commands\PxLoadView\LoadViewJsAsset;
use App\Traits\PxTraits\Commands\PxLoadView\LoadViewRoute;
use App\Traits\PxTraits\Commands\PxLoadView\LoadViewView;
use App\Traits\PxTraits\Commands\PxModal\ModalCreateController;
use App\Traits\PxTraits\Commands\PxModal\ModalCreateJsAsset;
use App\Traits\PxTraits\Commands\PxModal\ModalCreateRoute;
use App\Traits\PxTraits\Commands\PxModal\ModalCreateView;
use App\Traits\PxTraits\Commands\PxReact\ReactCreateComponent;
use App\Traits\PxTraits\Commands\PxReact\ReactCreateController;
use App\Traits\PxTraits\Commands\PxReact\ReactCreateRoute;
use App\Traits\PxTraits\Commands\PxReact\ReactCreateView;

trait BaseCommand
{
    public function LangFileString($model,$pageDotUrl)
    {
        $codeString = <<<PHP
        <?php
            return [
                "breadCum" => [
                    "tabTitle" => " B1 | B2 | B3",
                    "B1" => "B1",
                    "B2" => "B2",
                    "B3" => "B3",
                ],
                "titles" => [
                    "main_title" => "Main Title",
                    "add_title" => "Add New Element",
                    "update_title" => "Update Element"
                ],
                "inputs" => [
                    "name" => "Name"
                ],
                "table" => [
                    "col" => [
                        "id" => "ID",
                        "name" => "Name",
                        "created" => "Created",
                        "action" => "Actions"
                    ]
                ]
            ];
        PHP;
        return $codeString;
    }
    //crud
    use ModelMigration, CrudControllers, CrudViews, CrudRequest, CrudRepository, CrudJsAsset,CrudRoute;

    //datatable 
    use DtCreateRoute,DtCreateController,DtCreateViews,DtCreateRepository, DtCreateJsAsset;

    //form
    use FormCreateRoute, FormCreateController, FormCreateViews, FormCreateRepositoy, FormCreateJsAsset, FormCreateRequest;

    //modal
    use ModalCreateRoute,ModalCreateController, ModalCreateView, ModalCreateJsAsset;

    //loadview
    use LoadViewRoute, LoadViewController, LoadViewView, LoadViewJsAsset;

    //react
    use ReactCreateComponent, ReactCreateRoute, ReactCreateController, ReactCreateView;

    //dataview
    use DataViewCreateRoute,DataViewCreateController,DataViewCreateViews;
}
