<?php
namespace GDO\GDO6DB;

use GDO\Core\GDO_DBException;
use GDO\Core\GDO_Module;
use GDO\Core\GDT_Secret;
use GDO\DB\Database;

final class Module_GDO6DB extends GDO_Module
{
    public function onLoadLanguage(): void
    {
        $this->loadLanguage('lang/gdo6db');
    }

    public function getConfig(): array
    {
        return [
            GDT_Secret::make('gdo6_db_host')->initial('localhost'),
            GDT_Secret::make('gdo6_db_name'),
            GDT_Secret::make('gdo6_db_user'),
            GDT_Secret::make('gdo6_db_pass'),
        ];
    }

    public function cfgDBHost(): ?string
    {
        return $this->getConfigVar('gdo6_db_host');
    }

    public function cfgDBName(): ?string
    {
        return $this->getConfigVar('gdo6_db_name');
    }

    public function cfgDBUser(): ?string
    {
        return $this->getConfigVar('gdo6_db_user');
    }

    public function cfgDBPass(): ?string
    {
        return $this->getConfigVar('gdo6_db_pass');
    }

    /**
     * @throws GDO_DBException
     */
    public function cfgGDO6DB(): Database
    {
        static $DB;
        if (!isset($DB))
        {
            $DB = new Database($this->cfgDBHost(), $this->cfgDBUser(), $this->cfgDBPass(), $this->cfgDBName());
            $DB->connect();
        }
        return $DB;
    }

}
