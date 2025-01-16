<!doctype html>
<html lang="en">
<head>
    <title>QR Code Generator</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <style>
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .qr-code-display {
            text-align: center;
            margin-top: 20px;
        }
        .qr-code-display img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title">Generate Your QR Code</h4>
            <p class="card-text">Choose an option and fill the form to generate a QR code.</p>
        </div>
        <div class="card-body">
            <form action="{{ url('/generate-qr-code') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="qrType" class="form-label">Select QR Code Type</label>
                    <select class="form-select" id="qrType" name="type" required>
                        <option value="">Choose...</option>
                        <option value="url">URL</option>
                        <option value="text">Text</option>
                        <option value="email">Email</option>
                        <option value="wifi">Wi-Fi</option>
                        <option value="phone">Phone Number</option>
                    </select>
                </div>

                <!-- Dynamic Input Fields -->
                <div id="dynamicInputs">
                    <!-- Inputs will be dynamically injected here -->
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-success btn-lg">Generate QR Code</button>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-success btn-lg">Generate QR Code updaed for merge</button>
                </div>
            </form>
        </div>
        <div class="card-footer qr-code-display" id="qrCodeDisplay">
            @if (session('qrCode'))
                <h5>Your QR Code</h5>
                <div>{!! session('qrCode') !!}</div>
            @endif
        </div>
    </div>
</div>

<script>
    const qrType = document.getElementById('qrType');
    const dynamicInputs = document.getElementById('dynamicInputs');

    qrType.addEventListener('change', () => {
        let inputHtml = '';
        switch (qrType.value) {
            case 'url':
                inputHtml = `
                    <label for="url" class="form-label">Enter URL</label>
                    <input type="url" class="form-control" id="url" name="url" placeholder="https://example.com" required>
                `;
                break;

            case 'text':
                inputHtml = `
                    <label for="text" class="form-label">Enter Text</label>
                    <textarea class="form-control" id="text" name="text" rows="3" placeholder="Enter your text here..." required></textarea>
                `;
                break;

            case 'email':
                inputHtml = `
                    <label for="email" class="form-label">Enter Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com" required>
                `;
                break;

            case 'wifi':
                inputHtml = `
                    <label for="ssid" class="form-label">Wi-Fi SSID</label>
                    <input type="text" class="form-control mb-2" id="ssid" name="ssid" placeholder="Enter Wi-Fi SSID" required>
                    <label for="password" class="form-label">Wi-Fi Password</label>
                    <input type="password" class="form-control mb-2" id="password" name="password" placeholder="Enter Wi-Fi Password">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="hidden" name="hidden" value="true">
                        <label class="form-check-label" for="hidden">Hidden Network</label>
                    </div>
                `;
                break;

            case 'phone':
                inputHtml = `
                    <label for="phone" class="form-label">Enter Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1234567890" required>
                `;
                break;

            default:
                inputHtml = '';
        }
        dynamicInputs.innerHTML = inputHtml;
    });
</script>
</body>
</html>
