@foreach ($inbounds as $inbound)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $inbound->kode_po }}</td>
        <td>{{ $inbound->supplier->nama_supplier }}</td>
        <td>{{ $inbound->eta }}</td>
        <td>{{ $inbound->catatan ?? 'Tidak Ada Catatan' }}</td>
        <td>{{ $inbound->purchaseOrder ? $inbound->purchaseOrder->status : 'Tidak Ada Status' }}</td>
        <td class="text-center">
            <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)"
                onclick="confirmDelete('{{ $inbound->kode_po }}')" type="button">
                <!-- Icon Trash -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-trash-2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6l-2 14H7L5 6"></path>
                    <path d="M10 11v6"></path>
                    <path d="M14 11v6"></path>
                </svg>
                Hapus
            </a>
            <a href="{{ route('inbound.admin.edit', Crypt::encryptString($inbound->kode_po)) }}"
                class="btn btn-outline-primary btn-rounded mb-2 me-4">
                <!-- Icon Edit -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-edit">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                    </path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                    </path>
                </svg>
                Edit
            </a>
            <button type="button" class="btn btn-outline-info btn-rounded mb-2 me-4 btn-preview"
                data-id="{{ $inbound->kode_po }}">
                Preview
            </button>
            <a href="{{ route('detail.inbond.admin', Crypt::encryptString($inbound->kode_po)) }}"
                class="btn btn-outline-info btn-rounded mb-2 me-4">
                <!-- Icon View -->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-eye" viewBox="0 0 16 16">
                    <path
                        d="M8 3C4.5 3 1.757 6.325 1 8c.757 1.675 3.5 5 7 5s6.243-3.325 7-5c-.757-1.675-3.5-5-7-5zm0 1c2.635 0 5.015 2.055 5.732 3-.717.945-3.097 3-5.732 3-2.635 0-5.015-2.055-5.732-3 .717-.945 3.097-3 5.732-3zm0 1.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                </svg>
                Detail
            </a>
        </td>
    </tr>
@endforeach
