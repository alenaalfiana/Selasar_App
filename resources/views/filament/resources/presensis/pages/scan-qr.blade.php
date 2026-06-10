<x-filament-panels::page>
    <div class="space-y-4">
        <div id="reader" style="width: 100%; max-width: 600px; margin: 0 auto;"></div>
        
        <div class="text-center mt-4">
            <p class="mb-2">Atau masukkan kode tiket manual:</p>
            <input type="text" id="manual_code" class="border p-2 rounded text-black w-full max-w-xs" placeholder="KODE TIKET" />
            <button onclick="submitManual()" class="bg-primary-600 text-white px-4 py-2 rounded ml-2">Submit</button>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
            
            function onScanSuccess(decodedText, decodedResult) {
                html5QrcodeScanner.clear();
                @this.processScan(decodedText);
            }

            function onScanFailure(error) {
                // handle failure
            }

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });

        function submitManual() {
            let code = document.getElementById('manual_code').value;
            if(code) {
                @this.processScan(code);
                document.getElementById('manual_code').value = '';
            }
        }
    </script>
</x-filament-panels::page>
