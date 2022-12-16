<x-dash.layout.master>
    <x-slot name="header">
        <x-dash.layout.header></x-dash.layout.header>
    </x-slot>
    <x-slot name="left_sidebar">
        <x-dash.layout.left_sidebar></x-dash.layout.left_sidebar>
    </x-slot>
    <x-slot name="toolbar">
        <x-dash.toolbar>
            <x-slot name="title">
                <x-dash.heading.title title="Dashboard"></x-dash.heading.title>
                <x-dash.breadcrumb></x-dash.breadcrumb>
            </x-slot>
            <x-slot name="action">
                <x-dash.anchor.btn text="Dashboard"></x-dash.anchor.btn>
            </x-slot>
        </x-dash.toolbar>
    </x-slot>
    <x-slot name="content">
        <x-dash.card title="Recent Orders" subTitle="Over 500 orders">
            <x-slot name="action">
                <x-dash.anchor.btn text="Card Button"></x-dash.anchor.btn>
            </x-slot>
            <x-slot name="body">
                <x-dash.table :th="[
                        ['title' => 'Order Id'],
                        ['title' => 'Country'],
                        ['title' => 'Date'],
                        ['title' => 'Company'],
                        ['title' => 'Total'],
                        ['title' => 'Status'],
                        ['title' => 'Actions', 'class'=>'text-end']
                        ]">
                    <x-slot name="tBodyRow">

                    </x-slot>
                </x-dash.table>
            </x-slot>
        </x-dash.card>
    </x-slot>
    <x-slot name="footer">
        <x-dash.layout.footer></x-dash.layout.footer>
    </x-slot>
</x-dash.layout.master>
