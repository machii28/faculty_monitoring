<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\Room;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Prologue\Alerts\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait GenerateQRCodeOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupGenerateQRCodeRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{roomId}/generateQRCode', [
            'as'        => $routeName.'.generateQRCode',
            'uses'      => $controller.'@generateQRCode',
            'operation' => 'generateQRCode',
        ]);

        Route::get($segment . '/{roomId}/generate', [
            'as' => $routeName.'.generate',
            'uses' => $controller . '@generate',
            'operation' => 'generateQRCode'
        ]);

        Route::get($segment . '/{roomId}/print', [
            'as' => $routeName . '.print',
            'uses' => $controller . '@print',
            'operation' => 'generateQRCode'
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupGenerateQRCodeDefaults()
    {
        CRUD::allowAccess('generateQRCode');

        CRUD::operation('generateQRCode', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'generate_q_r_code', 'view', 'crud::buttons.generate_q_r_code');
             CRUD::addButton('line', 'generate_q_r_code', 'view', 'crud::buttons.generate_q_r_code');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function generateQRCode($roomId)
    {
        CRUD::hasAccessOrFail('generateQRCode');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Generate Q R Code '.$this->crud->entity_name;
        $this->data['roomId'] = $roomId;

        // load the view
        return view('crud::operations.generate_q_r_code', $this->data);
    }

    public function print($roomId)
    {
        $room = Room::where('id', $roomId)->first();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('print', [
            'room' => $room
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('room-qr-'. $roomId .'.pdf');
    }

    public function generate($roomId)
    {
        $room = Room::where('id', $roomId)->first();
        CRUD::hasAccessOrFail('generateQRCode');
        $path = '../storage/app/public/qrcodes/';

        if (!\Illuminate\Support\Facades\File::isDirectory($path)) {
            File::makeDirectory('../storage/app/public/qrcodes', 0777, true);
        }

        QrCode::color(7, 34, 209)
            ->style('square')
            ->size(500)->generate($roomId, $path . $room->id . '.svg');

        $room->qr_code_path = '/qrcodes/' . $room->id . '.svg';
        $room->save();

        Alert::success('<strong>Success! </strong> QR Code Generated')->flash();

        return Redirect::route('room.index');
    }
}
