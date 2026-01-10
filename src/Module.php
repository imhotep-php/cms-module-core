<?php declare(strict_types=1);

namespace Modules\Core;

use Imhotep\Cms\Module as BaseModule;
use Imhotep\Cms\UI\Sidebar\Sidebar;
use Imhotep\Cms\UI\UI;

class Module extends BaseModule
{
    public function getName(): string
    {
        return 'core';
    }

    public function getVersion(): string
    {
        return '1.0.0';
    }

    public function boot(): void
    {
        parent::boot();

        $this->loadRoutes();
        //$this->loadViews('nexus');
    }

    public function navigation(): array
    {
        return [
            Sidebar::item('modules', 'Модули', 'modules', 'fas fa-puzzle-piece')->build(),
            Sidebar::item('settings', 'Настройки', 'settings', 'fas fa-cog')->build()
        ];
    }


    public function getAdminRoutes(): array
    {
        return [
            'modules' => [
                'method' => 'GET',
                'uri' => '/modules',
            ],
            'settings' => [
                'method' => 'GET',
                'uri' => '/settings',
            ],
        ];
    }

    public function getAdminPage(string $page): array
    {
        return $this->getSettingPage();
    }

    protected function getSettingPage(): array
    {
        return UI::page()
            ->header(
                UI::header('Настройки сайта')
            )
            ->addContent(
                UI::grid(6)
                    ->addContent(
                        UI::section('<i class="fas fa-globe"></i>Информация')
                            ->addContent(
                                UI::form('/admin/api/settings', 'Сохранить')
                                    ->addField(UI::fieldInput('Site Title', 'title'))
                                    ->addField(UI::fieldTextarea('Site Description', 'description'))
                            )
                    )
                    ->addContent(
                        UI::section('<i class="fas fa-sliders-h"></i>Конфигурация')
                            ->addContent(
                                UI::form('/admin/api/settings', 'Сохранить')
                                    ->addField(UI::fieldSelect('Часовой пояс', 'timezone'))
                                    ->addField(UI::fieldSelect('Формат даты', 'date_format'))
                                    ->addField(UI::fieldSelect('Основной язык', 'language'))
                            )

                    )
            )
            ->build();
    }
}