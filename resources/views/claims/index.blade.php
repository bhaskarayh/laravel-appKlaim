<!DOCTYPE html>
<html>
    <head>
        <title>Claims Summary and Details</title>
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
        <style>
            .summary-row {
                font-weight: bold;
                background-color: #198754;
                color: white;
            }

            .summary-total-row {
                font-weight: bold;
                background-color: #6b7075;
                color: white;
            }
            .detail-row {
                padding-left: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container mt-4">
            <h1 class="mb-4">Claims Summary and Details</h1>

            <!-- Display detailed and summary data in a combined table -->
            <table class="table-bordered table">
                <thead class="thead-dark text-center">
                    <tr>
                        <th>Sub COB</th>
                        <th>Penyebab Klaim</th>
                        <th>Jumlah Nasabah</th>
                        <th>Beban Klaim</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentSubCob = null;
                        $subCobTotal = 0;
                        $subCobCount = 0;

                        $totalNasabah = 0;
                        $totalBebanKlaim = 0;
                    @endphp

                    @foreach ($combinedData as $item)
                        @if ($currentSubCob !== $item->sub_cob)
                            @if ($currentSubCob !== null)
                                <!-- Summary row for the previous LOB -->
                                <tr class="summary-row">
                                    <td colspan="2">{{ $currentSubCob }}</td>
                                    {{-- <td>Total</td> --}}
                                    <td>{{ $subCobCount }}</td>
                                    <td>{{ number_format($subCobTotal, 2) }}</td>
                                </tr>
                            @endif

                            <!-- Reset totals for the new LOB -->
                            @php
                                $currentSubCob = $item->sub_cob;
                                $subCobTotal = 0;
                                $subCobCount = 0;
                            @endphp
                        @endif

                        <!-- Detailed row for each penyebab_klaim within the current LOB -->
                        <tr>
                            <td>{{ $item->sub_cob }}</td>
                            <td>{{ $item->penyebab_klaim }}</td>
                            <td>{{ $item->total_klaim }}</td>
                            <td>{{ number_format($item->total_nilai_beban_klaim, 2) }}</td>
                        </tr>

                        @php
                            $subCobTotal += $item->total_nilai_beban_klaim;
                            $subCobCount += $item->total_klaim;

                            $totalNasabah += $item->total_klaim;
                            $totalBebanKlaim += $item->total_nilai_beban_klaim;
                        @endphp
                    @endforeach

                    <!-- Summary row for the last LOB -->
                    @if ($currentSubCob !== null)
                        <tr class="summary-row">
                            <td colspan="2">{{ $currentSubCob }}</td>
                            {{-- <td>Total</td> --}}
                            <td>{{ $subCobCount }}</td>
                            <td>{{ number_format($subCobTotal, 2) }}</td>
                        </tr>

                        <tr class="summary-total-row">
                            <td colspan="2">Total</td>
                            {{-- <td>Total</td> --}}
                            <td>{{ $totalNasabah }}</td>
                            <td>{{ number_format($totalBebanKlaim, 2) }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Loading overlay -->
            {{--
                <div class="loading-overlay" id="loadingOverlay">
                <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                </div>
            --}}

            <form action="{{ route('claims.export') }}" method="POST" id="exportForm">
                @csrf
                <button type="submit" class="btn btn-primary">Export to Penampungan</button>
            </form>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#exportForm').on('submit', function () {
                    $('#loadingOverlay').show(); // Show loading screen
                });
            });
        </script>
    </body>
</html>
