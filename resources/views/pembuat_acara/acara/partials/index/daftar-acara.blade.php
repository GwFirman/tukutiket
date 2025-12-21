<div class="max-w-7xl mx-auto px-6 py-6">
    {{-- <!-- Filters sederhana -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input id="search" type="text" placeholder="Cari nama acara atau lokasi..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <select id="status"
                class="px-3 py-2.5 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Semua</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="archived">Archived</option>
            </select>
        </div>
    </div> --}}

    <div class="bg-white rounded-xl  overflow-hidden">
        <div class="overflow-x-auto">
            <table id="acara-table" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase">Banner</th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase">Nama & Lokasi
                        </th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase">Waktu</th>
                        <th class="px-4 py-2.5 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                        <th class="px-4 py-2.5 text-center text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables assets -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    /* Harmonize DataTables with Tailwind */
    table.dataTable tbody tr {
        transition: background-color .15s ease;
    }

    table.dataTable tbody tr:hover {
        background-color: #f8fafc;
    }

    table.dataTable td,
    table.dataTable th {
        padding: .75rem 1rem;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d1d5db;
        border-radius: .5rem;
        padding: .5rem .75rem;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #d1d5db;
        border-radius: .5rem;
        padding: .375rem .5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: .5rem;
        border: 1px solid #e5e7eb;
        margin: 0 .125rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #4338ca !important;
    }
</style>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(function() {
        const table = $('#acara-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('pembuat.acara.table-data') }}',
                data: function(d) {
                    d.status = $('#status').val();
                    d.search_text = $('#search').val();
                }
            },
            columns: [{
                    data: 'banner',
                    name: 'banner',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_lokasi',
                    name: 'nama_acara'
                },
                {
                    data: 'waktu',
                    name: 'waktu_mulai'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [
                [2, 'desc']
            ],
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            // UI improvements
            pageLength: 10,
            lengthMenu: [10, 25, 50],
            dom: '<"flex items-center justify-between mb-3"lf>t<"flex items-center justify-between mt-3"ip>',
            drawCallback: function() {
                // Apply lucide icons after draw
                if (window.lucide && typeof window.lucide.createIcons === 'function') {
                    window.lucide.createIcons();
                }
            }
        });

        // Hook filters
        $('#status').on('change', function() {
            table.draw();
        });
        $('#search').on('keyup', function() {
            table.draw();
        });
    });
</script>
