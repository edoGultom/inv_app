<?php

use common\models\AktivitasHarian;
use common\models\InstruksiPimpinanPelaksana;
use common\models\Skp;
use yii\widgets\Menu;
use yii\bootstrap5\Html;
?>
<?php

$menuItems = [];
$menuItems[] = [
        'label' => 'Menu Utama',
        'options' => ['class' => 'nav-label mg-t-25']
];

$menuItems[] = [
        'label' => '<i class="fas fa-house me-2"></i><span>Dashboard</span>',
        'options' => ['class' => 'nav-item'],
        'url' => ['/site/index']
];

if (Yii::$app->user->can('ASN')) {

        $menuItems[] = [
                'label' => '<i class="fa-solid fa-toolbox me-2"></i> <span>Barang</span>',
                'options' => ['class' => 'nav-item with-sub'],
                'url' => "#",
                'items' => [
                        [
                                'label' => '<i class="fa-solid fa-hand-holding-hand"></i> Permintaan Barang',
                                'url' => ['/barang-usulan/index'],
                                'template' => '<a href="{url}" >{label}</a>',
                        ],
                        [
                                'label' => '<i class="fa-solid fa-handshake"></i> Peminjaman Aset',
                                'url' => ['/aset-usulan/index'],
                                'template' => '<a href="{url}" >{label}</a>',
                        ],
                ],
        ];
}
if (Yii::$app->user->can('Verifikator')) {

        $menuItems[] = [
                'label' => '<i class="fa-solid fa-folder-plus me-2"></i> <span>Barang</span>',
                'options' => ['class' => 'nav-item with-sub'],
                'url' => "#",
                'items' => [
                        [
                                'label' => '<i class="fa-solid fa-toolbox"></i> Data Barang',
                                'url' => ['/barang/index'],
                                'template' => '<a href="{url}" >{label}</a>',
                        ],
                ],
        ];
        $menuItems[] = [
                'label' => '<i class="fa-solid fa-toolbox me-2"></i> <span>Verifikasi</span>',
                'options' => ['class' => 'nav-item with-sub'],
                'url' => "#",
                'items' => [
                        [
                                'label' => '<i class="fa-solid fa-file-circle-check"></i> Permintaan Barang',
                                'url' => ['/usulan-barang-verifikator/index'],
                                'template' => '<a href="{url}" >{label}</a>',
                        ],
                        [
                                'label' => '<i class="fa-solid fa-envelope-circle-check"></i> Peminjaman Aset',
                                'url' => ['/usulan-aset-verifikator/index'],
                                'template' => '<a href="{url}" >{label}</a>',
                        ],
                ],
        ];
        $menuItems[] = [
                'label' => '<i class="fa-solid fa-file-circle-check me-2"></i> <span>Laporan</span>',
                'options' => ['class' => 'nav-item with-sub'],
                'url' => "#",
                'items' => [
                        [
                                'label' => '<i class="fa-solid fa-file-arrow-down"></i> Barang Masuk',
                                'url' => ['/laporan-barang-masuk/index'],
                                'template' => '<a href="{url}" >{label}</a>',
                        ],
                        [
                                'label' => '<i class="fa-solid fa-file-arrow-up"></i> Barang Keluar',
                                'url' => ['/laporan-barang-keluar/index'],
                                'template' => '<a href="{url}" >{label}</a>',
                        ],
                ],
        ];

        $menuItems[] = [
                'label' => '<i class="fa-solid fa-file-lines me-2"></i> <span>Referensi</span>',
                'options' => ['class' => 'nav-item with-sub'],
                'url' => "#",
                'items' => [
                        [
                                'label' => 'Referensi Barang',
                                'url' => ['/ref-kategori-barang/index'],
                                'template' => '<a href="{url}" >{label}</a>',
                        ],
                        [
                                'label' => 'Referensi Unit',
                                'url' => ['/ref-unit/index'],
                                'template' => '<a href="{url}" >{label}</a>',
                        ],
                ],
        ];
}

$menuItems[] = [
        'label' => 'Pengaturan',
        'options' => ['class' => 'nav-label mg-t-25']
];
if (Yii::$app->user->can('Verifikator')) {
        $menuItems[] = [
                'label' => '
                <div class="d-flex flex-row justify-content-between align-items-center w-100">
                        <span><i class="fas fa-users me-2"></i>Pengguna</span>
                </div>',
                'options' => ['class' => 'nav-item'],
                'url' => ['/pengguna/index']
        ];
}

$menuItems[] = [
        'label' => Html::a('<i class="fas fa-sign-out me-2"></i><span> Keluar</span>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']),
        // 'url' => ['/site/logout'],
];
echo Menu::widget([
        'items' => $menuItems,
        'activateItems' => true,
        'activateParents' => false,
        'activeCssClass' => 'active',
        'options' => ['class' => 'nav nav-aside'],
        'itemOptions' => ['class' => 'nav-item'],
        'linkTemplate' => '<a href="{url}" class="nav-link" aria-expanded="false">{label}</a>',
        'encodeLabels' => false,
        'submenuTemplate' => '<ul>{items}</ul>',
        'activateParents' => true,
        // 'firstItemCssClass' => 'first-menu'

]);
?>