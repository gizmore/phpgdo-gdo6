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
        return $this->message('msg_gdo6db_converted');
    }

}
