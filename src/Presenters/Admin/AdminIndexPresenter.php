<?php

namespace Cant\Phase\Me\Presenters\Admin;

use Cant\Phase\Me\Handler\Server;
use Cant\Phase\Me\Layouts\AdminLayout;
use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Patterns\Mvp\Crud\ModelForm\ModelFormPresenter;

class AdminIndexPresenter extends ModelFormPresenter
{
    protected function createView()
    {
        LayoutModule::setLayoutClassName( AdminLayout::class );
        return new AdminIndexView();
    }

    protected function configureView()
    {
        $this->view->attachEventHandler( 'Heartbeat', function()
        {
            $server = new Server();
            $class = new \stdClass();
            $class->Uptime = "Up: " . $server->getServerUptime();
            $class->Online = $this->view->GetPlayerRowsHTML();
            return $class;
        });

        $this->view->attachEventHandler( 'GetPage', function( $name )
        {
            switch( $name )
            {
                case 'server-overview':
                    return $this->view->getServerOverview();
                case 'reports':
                    return $this->view->getReports();
                case 'item-edit':
                    return $this->view->getItemEditor();
            }
        });
        return parent::configureView();
    }
}