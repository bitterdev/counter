<?php

namespace Concrete\Package\Counter\Block\MultipleCounters;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Database\Connection\Connection;
use Concrete\Core\Error\ErrorList\ErrorList;

class Controller extends BlockController
{
    protected $btTable = 'btMultipleCounters';
    protected $btInterfaceWidth = 400;
    protected $btInterfaceHeight = 500;

    public function getBlockTypeDescription()
    {
        return t("Display mulitple animated numbers on your website.");
    }

    public function getBlockTypeName()
    {
        return t("Multiple Counters");
    }

    public function view()
    {
        /** @var Connection $db */
        $db = $this->app->make(Connection::class);
        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $this->set("items", $db->fetchAll("SELECT * FROM btMultipleCounterItems WHERE bID = ?", [$this->bID]));
    }

    public function add()
    {
        $this->set("items", []);
        $this->set("duration", 1000);
    }

    public function getSearchableContent()
    {
        /** @var Connection $db */
        $db = $this->app->make(Connection::class);
        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $items = $db->fetchAll("SELECT * FROM btMultipleCounterItems WHERE bID = ?", [$this->bID]);

        $content = "";

        if (is_array($items)) {
            foreach ($items as $item) {
                $content .= sprintf(
                    "%s%s",
                    ($content != "" ? " " : ""),
                    strip_tags($item["description"])
                );
            }
        }

        return $content;
    }

    public function edit()
    {
        /** @var Connection $db */
        $db = $this->app->make(Connection::class);
        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $this->set("items", $db->fetchAll("SELECT * FROM btMultipleCounterItems WHERE bID = ?", [$this->bID]));
    }

    public function delete()
    {
        /** @var Connection $db */
        $db = $this->app->make(Connection::class);
        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        /** @noinspection PhpUnhandledExceptionInspection */
        $db->executeQuery("DELETE FROM btMultipleCounterItems WHERE bID = ?", [$this->bID]);

        parent::delete();
    }

    public function save($args)
    {
        parent::save($args);

        /** @var Connection $db */
        $db = $this->app->make(Connection::class);
        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        /** @noinspection PhpUnhandledExceptionInspection */
        $db->executeQuery("DELETE FROM btMultipleCounterItems WHERE bID = ?", [$this->bID]);

        $args["items"] = $args["items"] ?? null;

        if (is_array($args["items"])) {
            foreach ($args["items"] as $item) {
                /** @noinspection SqlDialectInspection */
                /** @noinspection SqlNoDataSourceInspection */
                /** @noinspection PhpUnhandledExceptionInspection */
                $db->executeQuery("INSERT INTO btMultipleCounterItems (bID, `value`, description) VALUES (?, ?, ?)", [
                    $this->bID,
                    $item["value"],
                    $item["description"]
                ]);
            }
        }
    }

    public function duplicate($newBID)
    {
        parent::duplicate($newBID);

        /** @var Connection $db */
        $db = $this->app->make(Connection::class);

        $copyFields = '`value`, description';
        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        /** @noinspection PhpUnhandledExceptionInspection */
        $db->executeUpdate("INSERT INTO btMultipleCounterItems (bID, {$copyFields}) SELECT ?, {$copyFields} FROM btMultipleCounterItems WHERE bID = ?", [
                $newBID,
                $this->bID
            ]
        );
    }

    public function validate($args): ErrorList
    {
        $errorList = new ErrorList();

        if (!$args['duration'] || !is_numeric($args['duration']) || intval($args['duration']) < 0) {
            $errorList->add(t('You must specify a valid duration.'));
        }

        if (isset($args["items"]) && is_array($args["items"])) {
            $missingCounterValue = false;

            foreach ($args["items"] as $item) {
                if (intval($item["value"]) === 0) {
                    $missingCounterValue = true;

                    break;
                }
            }

            if ($missingCounterValue) {
                $errorList->add(t('You must specify a valid counter value.'));
            }
        }

        return $errorList;
    }

}
