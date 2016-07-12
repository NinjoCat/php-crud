<?php

namespace CRUDDemo;

use OLOG\BT\BT;
use OLOG\CRUD\CRUDTable;
use OLOG\CRUD\CRUDFormRow;
use OLOG\CRUD\CRUDTableColumn;
use OLOG\CRUD\CRUDTableWidgetDelete;
use OLOG\CRUD\CRUDTableWidgetText;
use OLOG\CRUD\CRUDTableWidgetTextWithLink;
use OLOG\CRUD\CRUDFormWidgetInput;

class DemoNodesListAction
{
    static public function getUrl()
    {
        return '/nodes';
    }

    public function action()
    {
        \OLOG\Exits::exit403If(!Auth::currentUserHasAnyOfPermissions([1]));

        $html = '';

        $html .= CRUDTable::html(
            DemoNode::class,
            \OLOG\CRUD\CRUDForm::html(
                new DemoNode(),
                [
                    new CRUDFormRow(
                        'Title',
                        new CRUDFormWidgetInput('title')
                    )
                ]
            ),
            [
                new CRUDTableColumn(
                    'Title',
                    new CRUDTableWidgetText('{this->title}')
                ),
                new CRUDTableColumn(
                    'Reverse title',
                    new CRUDTableWidgetText('{this->getReverseTitle()}')
                ),
                new CRUDTableColumn(
                    '',
                    new CRUDTableWidgetTextWithLink(
                        'Edit',
                        DemoNodeEditAction::getUrl('{this->id}'),
                        'btn btn-xs btn-default'
                    )
                ),
                new CRUDTableColumn(
                    '',
                    new CRUDTableWidgetDelete()
                ),
            ],
            [],
            'title'
        );

        DemoLayoutTemplate::render($html, 'Nodes', self::getBreadcrumbsArr());
    }

    static public function getBreadcrumbsArr()
    {
        return array_merge(DemoMainPageAction::breadcrumbsArr(), [BT::a(self::getUrl(), 'Nodes')]);
    }
}