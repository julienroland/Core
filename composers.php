<?php

View::creator('core::partials.sidebar-nav', 'Core\Composers\SidebarViewCreator');
View::composer('core::layouts.master', 'Core\Composers\MasterViewComposer');
