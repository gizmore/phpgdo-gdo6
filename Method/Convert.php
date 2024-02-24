<?php
namespace GDO\GDO6DB\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_Checkbox;
use GDO\Core\ModuleLoader;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;

final class Convert extends MethodForm
{

    public function isTrivial(): bool
    {
        return false;
    }

    protected function createForm(GDT_Form $form): void
    {
        $modules = ModuleLoader::instance()->getEnabledModules();
        foreach ($modules as $module)
        {
            $form->addField(GDT_Checkbox::make($module->getName())->initial('1'));
        }
        $form->actions()->addField(GDT_Submit::make());
    }

    public function formValidated(GDT_Form $form): GDT
    {
        $this->convertDB($form);
        return $this->message('msg_gdo6db_converted');
    }

    private function convertDB(GDT_Form $form): void
    {
        $vars = $form->getFormVars();
        foreach ($vars as $moduleName)
        {
            if (method_exists($this, "convert{$moduleName}"))
            {
                call_user_func([$this, "convert{$moduleName}"]);
            }
            else
            {
                $this->error('err_db6_method', [$moduleName]);
            }
        }
    }

}
