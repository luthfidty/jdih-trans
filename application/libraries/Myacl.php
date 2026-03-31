<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Myacl
{

    protected $restrictFunction = array("__construct", "_rules", "_verify", "_loadConfig", "_auth", "_mobiledetect", "_removeRestrictFunction", "_hasAccess", "_generateMenus", "_generateButtons", "_getFunction", "get_instance", "_getModulesName", "_visitorCounter");
    protected $CI;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('auth/Routings_model');
    }

    private function _removeRestrictFunction($functions)
    {
        $funcs = array_diff($functions, $this->restrictFunction);
        $extFunc = array('_rules', '_action', 'ajax_');
        foreach ($extFunc as $sk) {
            foreach ($funcs as $key => $v) {
                if (strpos($v, $sk) !== false) {
                    unset($funcs[$key]);
                }
            }
        }
        return $funcs;
    }

    public function _getFunction($classname)
    {
        foreach ($this->_getModulesName() as $m => $name) {
            if (file_exists(MODULEPATH . $name . '/controllers/' . $classname . '.php')) {
                include_once MODULEPATH . $name . '/controllers/' . $classname . '.php';
                $methods = get_class_methods(str_replace('.php', '', $classname));
                $funclist = $this->_removeRestrictFunction($methods);
                return array("module" => $name, "class" => $classname, "functions" => $funclist);
            }
        }
    }

    public function _hasAccess($reqUrl, $roles)
    {

        if (in_array($reqUrl, $roles)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function _generateMenus($roles)
    {
        $menus = array();
        foreach ($roles as $k => $v) {
            if ($k == 'rolename') {
                continue;
            }
            $url = $this->CI->Routings_model->get_by_routename($k);
            $menu['name'] = $k;
            $menu['alias'] = $url->routealias;
            $menu['icon'] = $url->icon;
            $menu['url'] = base_url($url->routeurl);

            if (is_array($v)) {
                $menu['submenu'] = array();
                foreach ($v as $sm) {
                    $submenu['name'] = $sm;
                    $submenu['url'] = base_url($url->routeurl . '/' . $sm);
                    $menu['submenu'][$sm] = $submenu;
                }
            }
            array_push($menus, $menu);
        }
        return $menus;
    }

    public function _generateButtons($roles)
    {
        $menus = array();
        foreach ($roles as $k => $v) {
            if ($k == 'rolename') {
                continue;
            }
            $url = $this->CI->Routings_model->get_by_routename($k);
            $menu['name'] = $k;

            if (is_array($v)) {
                $menu['submenu'] = array();
                foreach ($v as $sm) {
                    $submenu['url'] = base_url($url->routeurl . '/' . $sm);
                    $menu['submenu'][$sm] = $submenu;
                }
            }
            array_push($menus, $menu);
        }
        return $menus;
    }

    public function _getModulesName()
    {
        return array_diff(scandir(APPPATH . '/modules/'), array('.', '..'));
    }

    public function _ModuleExist($module)
    {
        $modules = $this->_getModulesName();
        if (in_array($module, $modules)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function _functionExist($module, $route, $function)
    {
        if (file_exists(MODULEPATH . $module . '/controllers/' . $route . '.php')) {
            include_once MODULEPATH . $module . '/controllers/' . $route . '.php';
            $methods = get_class_methods(str_replace('.php', '', $route));
            $funclist = $this->_removeRestrictFunction($methods);
            if (in_array($function, $funclist)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    public function _btnRead($uri, $text = "")
    {
        $iconMargin = $text ? 'mr-1' : '';
        return '<a href="' . $uri . '" class="inline-flex items-center px-3 py-1 text-sm text-white bg-green-500 hover:bg-green-600 rounded-md mr-2">
                <i class="fas fa-eye ' . $iconMargin . '"></i>' . ($text ? '<span class="hidden sm:inline">' . $text . '</span>' : '') . '
            </a>';
    }

    public function _btnCreate($uri, $text = "")
    {
        $iconMargin = $text ? 'mr-1' : '';
        return '<a href="' . $uri . '" class="inline-flex items-center px-3 py-1 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md mr-2">
                <i class="fas fa-pen-square ' . $iconMargin . '"></i>' . ($text ? '<span class="hidden sm:inline">' . $text . '</span>' : '') . '
            </a>';
    }

    public function _btnUpdate($uri, $text = "")
    {
        $iconMargin = $text ? 'mr-1' : '';
        return '<a href="' . $uri . '" class="inline-flex items-center px-3 py-1 text-sm text-white bg-cyan-600 hover:bg-cyan-700 rounded-md mr-2">
                <i class="fas fa-pen ' . $iconMargin . '"></i>' . ($text ? '<span class="hidden sm:inline">' . $text . '</span>' : '') . '
            </a>';
    }

    public function _btnDelete($uri, $text = "")
    {
        $iconMargin = $text ? 'mr-1' : '';
        return '<a href="' . $uri . '" onclick="return confirm(\'Anda Yakin Ingin Hapus Data ?\')"
                class="inline-flex items-center px-3 py-1 text-sm text-white bg-yellow-500 hover:bg-yellow-600 rounded-md mr-2">
                <i class="fas fa-trash ' . $iconMargin . '"></i>' . ($text ? '<span class="hidden sm:inline">' . $text . '</span>' : '') . '
            </a>';
    }

    public function _btnDefault($uri, $text = "", $class = 'bg-gray-500 hover:bg-gray-600', $icons = "fa-square", $target = false)
    {
        $iconMargin = $text ? 'mr-1' : '';
        return '<a href="' . $uri . '" ' . ($target ? 'target="_blank"' : '') . '
                class="inline-flex items-center px-3 py-1 text-sm text-white ' . $class . ' rounded-md mr-2">
                <i class="fas ' . $icons . ' ' . $iconMargin . '"></i>' . ($text ? '<span class="hidden sm:inline">' . $text . '</span>' : '') . '
            </a>';
    }

    public function _btnBack($uri, $text = "")
    {
        $iconMargin = $text ? 'mr-1' : '';
        return '<a href="' . $uri . '" class="inline-flex items-center px-3 py-1 text-sm text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md mr-2">
                <i class="fas fa-arrow-left ' . $iconMargin . '"></i>' . ($text ? '<span class="hidden sm:inline">' . $text . '</span>' : '') . '
            </a>';
    }

    public function _btnCancel($text = "Cancel")
    {
        $iconMargin = $text ? 'mr-1' : '';
        return '<button type="reset" onclick="history.back()" class="inline-flex items-center px-3 py-1 text-sm text-white bg-yellow-500 hover:bg-yellow-600 rounded-md mr-2">
                <i class="fas fa-times ' . $iconMargin . '"></i>' . ($text ? '<span class="hidden sm:inline">' . $text . '</span>' : '') . '
            </button>';
    }

    public function _btnSubmit($text = "Submit", $class = "bg-blue-500 hover:bg-blue-600", $icons = "fa-check")
    {
        $iconMargin = $text ? 'mr-1' : '';
        return '<button type="submit" class="inline-flex items-center px-3 py-1 text-sm text-white ' . $class . ' rounded-md mr-2">
                <i class="fas ' . $icons . ' ' . $iconMargin . '"></i>' . ($text ? '<span class="hidden sm:inline">' . $text . '</span>' : '') . '
            </button>';
    }


}
