@extends('layouts.admin')

@section('content')
<div style="padding-top: 80px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="card-title">Visualisasi Penyebaran Produk di Indonesia</h3>
                        <p class="text-muted">Klik pada provinsi untuk melihat detail produk yang terjual</p>
                        <button id="back-to-provinces" class="btn btn-secondary btn-sm" style="display: none;">
                            <i class="fas fa-arrow-left"></i> Kembali ke Provinsi
                        </button>
                    </div>
                    
                    <!-- Filter Section -->
                    <div class="card-body border-bottom">
                        <form method="GET" action="{{ route('admin.product.distribution') }}" class="row g-3" id="filterForm">
                            <div class="col-md-4">
                                <label for="province_id" class="form-label">Provinsi</label>
                                <select class="form-select" id="province_id" name="province_id">
                                    <option value="">Semua Provinsi</option>
                                    @foreach($allProvinces as $province)
                                        <option value="{{ $province->province_id }}" {{ $selectedProvince == $province->province_id ? 'selected' : '' }}>
                                            {{ $province->province_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                                                <div class="col-md-4">
                        <label for="plant_type_id" class="form-label">Jenis Tanaman</label>
                        <select class="form-select" id="plant_type_id" name="plant_type_id">
                            <option value="">Semua Jenis Tanaman</option>
                            @foreach($allPlantTypes as $plantType)
                                <option value="{{ $plantType->plant_type_id }}" {{ $selectedPlantType == $plantType->plant_type_id ? 'selected' : '' }}>
                                    {{ $plantType->plant_type_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="product_id" class="form-label">Nama Produk</label>
                        <select class="form-select" id="product_id" name="product_id" disabled>
                            <option value="">Pilih Jenis Tanaman terlebih dahulu</option>
                            @foreach($allProducts as $product)
                                <option value="{{ $product->product_id }}" 
                                        data-plant-type="{{ $product->plant_type_id }}"
                                        {{ $selectedProduct == $product->product_id ? 'selected' : '' }}>
                                    {{ $product->product_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                                                <div class="col-md-4 d-flex align-items-end">
                        <a href="{{ route('admin.product.distribution') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh"></i> Reset
                        </a>
                    </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="map" style="height: 600px; width: 100%;"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Statistik Penyebaran</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h6>Total Provinsi dengan Transaksi</h6>
                                            <span class="badge bg-primary fs-6">{{ $provinceData->count() }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <h6>Total Produk Terjual</h6>
                                            <span class="badge bg-success fs-6">{{ $provinceData->sum('total_products') }}</span>
                                        </div>

                                        <div class="mb-3">
                                            <h6>Total Nilai Transaksi</h6>
                                            <span class="badge bg-warning fs-6">Rp {{ number_format($provinceData->sum('total_value')) }}</span>
                                        </div>
                                        
                                        @if($provinceData->count() == 0)
                                            <div class="alert alert-info mt-3">
                                                <i class="fas fa-info-circle"></i>
                                                Tidak ada data transaksi yang sesuai dengan filter yang dipilih. Peta tetap menampilkan semua provinsi dengan warna default.
                                            </div>
                                        @endif
                                        
                                        <!-- Ringkasan Distribusi berdasarkan Jenis Tanaman -->
                                        @if($selectedPlantType)
                                            <div class="mt-3" id="distribution-summary">
                                                <div class="card">
                                                    <div class="card-header bg-primary text-white">
                                                        <h6 class="mb-0">
                                                            <i class="fas fa-chart-pie"></i>
                                                            Ringkasan Distribusi Jenis Tanaman
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="text-muted">Memuat data distribusi...</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5>Detail Provinsi</h5>
                                    </div>
                                    <div class="card-body" id="province-detail">
                                        <p class="text-muted">Klik pada provinsi untuk melihat detail</p>
                                        <button id="show-regency-map" class="btn btn-sm btn-outline-primary mt-2" style="display: none;">
                                            <i class="fas fa-map"></i> Tampilkan Peta Kota/Kabupaten
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Data dari backend
const provinceData = @json($provinceData);
const provinceProducts = @json($provinceProducts);
const regencyData = @json($regencyData);
const regencyProducts = @json($regencyProducts);
const allProvinces = @json($allProvinces);
const allRegencies = @json($allRegencies);
const allProducts = @json($allProducts);

// Debug: Log data untuk memastikan mapping benar
console.log('Province Data:', provinceData);
console.log('Province Data Length:', provinceData ? provinceData.length : 0);
console.log('Province Products:', provinceProducts);
console.log('All Provinces:', allProvinces);
console.log('Regency Data:', regencyData);
console.log('Regency Data Length:', regencyData ? regencyData.length : 0);
console.log('Regency Products:', regencyProducts);
console.log('All Regencies Sample:', allRegencies.slice(0, 3));

// Inisialisasi peta dengan batasan area Indonesia
const map = L.map('map', {
    minZoom: 5.3,
    maxZoom: 10,
    maxBounds: [
        [-11.0, 95.0], // Southwest bounds (Lat, Lng)
        [6.0, 141.0]   // Northeast bounds (Lat, Lng)
    ],
    maxBoundsViscosity: 1.0 // Mencegah drag keluar dari bounds
}).setView([-2.548926, 118.014863], 5);

// Variabel untuk tracking level zoom
let currentLevel = 'province'; // 'province' atau 'regency'
let currentProvinceId = null;
let currentGeoJson = null;

// Tambahkan tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Load GeoJSON dari file eksternal
fetch('/provinces.json')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('GeoJSON loaded successfully:', data);
        
        // Tambahkan GeoJSON ke peta
        window.geojson = L.geoJson(data, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(map);
        
        // Tambahkan legend
        const legend = L.control({position: 'bottomright'});
        
        legend.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'info legend');
            const grades = [0, 2, 4, 6, 8, 10];
            
            div.innerHTML = '<h4>Jumlah Produk</h4>';
            
            for (let i = 0; i < grades.length; i++) {
                div.innerHTML +=
                    '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                    grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
            }
            
            return div;
        };
        
        legend.addTo(map);
        
        // Jika ada filter provinsi yang aktif, zoom ke provinsi tersebut
        const selectedProvinceId = document.getElementById('province_id').value;
        if (selectedProvinceId) {
            setTimeout(() => {
                const provinceFeature = findProvinceFeature(selectedProvinceId);
                if (provinceFeature) {
                    map.fitBounds(provinceFeature.getBounds());
                    currentProvinceId = parseInt(selectedProvinceId);
                    
                    // Update detail panel untuk provinsi yang dipilih
                    updateProvinceDetail(selectedProvinceId);
                    
                    // Load regency data jika ada
                    const provinceDataItem = provinceData.find(p => p.province_id == parseInt(selectedProvinceId));
                    if (provinceDataItem) {
                        loadRegencyData(currentProvinceId);
                    }
                    
                    // Update filter dropdown untuk menyesuaikan dengan provinsi yang dipilih
                    isProgrammaticChange = true;
                    document.getElementById('province_id').value = selectedProvinceId;
                }
            }, 1000); // Delay untuk memastikan map sudah ter-render
        }
    })
    .catch(error => {
        console.error('Error loading GeoJSON:', error);
        console.log('Using fallback GeoJSON');
        
        // Fallback ke GeoJSON sederhana jika file tidak dapat dimuat
        const simpleGeoJSON = {
            "type": "FeatureCollection",
            "features": [
                {
                    "type": "Feature",
                    "properties": {"KODE_PROV": "31", "PROVINSI": "DKI JAKARTA"},
                    "geometry": {"type": "Polygon", "coordinates": [[[106.293026, -6.479821], [106.293026, -5.479821], [107.293026, -5.479821], [107.293026, -6.479821], [106.293026, -6.479821]]]}
                }
            ]
        };
        
        window.geojson = L.geoJson(simpleGeoJSON, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(map);
    });

// Fungsi untuk mendapatkan warna berdasarkan jumlah produk
function getColor(count) {
    return count > 10 ? '#800026' :
           count > 8  ? '#BD0026' :
           count > 6  ? '#E31A1C' :
           count > 4  ? '#FC4E2A' :
           count > 2  ? '#FD8D3C' :
           count > 0  ? '#FEB24C' :
                        '#FED976';
}

// Fungsi untuk mendapatkan style berdasarkan data
function style(feature) {
    const geoJsonProvinceId = feature.properties.KODE_PROV;
    
    // Cek apakah data ada
    if (!provinceData || provinceData.length === 0) {
        console.log('No province data available, using default style');
        // Tetap gunakan nama dari database jika ada
        const masterProvince = allProvinces[parseInt(geoJsonProvinceId)];
        const provinceName = masterProvince ? masterProvince.province_name : feature.properties.PROVINSI;
        console.log('Province name from database:', provinceName);
        
        return {
            fillColor: '#FED976', // Default color untuk data kosong
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.3
        };
    }
    
    // Mapping langsung: KODE_PROV (string) ke province_id (integer)
    const provinceDataItem = provinceData.find(p => p.province_id == parseInt(geoJsonProvinceId));
    const masterProvince = allProvinces[parseInt(geoJsonProvinceId)];
    const provinceName = provinceDataItem ? provinceDataItem.province_name : (masterProvince ? masterProvince.province_name : feature.properties.PROVINSI);
    
    console.log('Styling province:', geoJsonProvinceId, provinceName);
    console.log('Found data:', provinceDataItem);
    
    const count = provinceDataItem ? provinceDataItem.total_products : 0;
    console.log('Count for province:', count);
    
    return {
        fillColor: getColor(count),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    };
}

// Fungsi untuk mendapatkan style kabupaten/kota berdasarkan data
function styleRegency(feature) {
    const geoJsonRegencyId = feature.properties.KDPKAB;
    
    // Cek apakah data ada
    if (!regencyData || regencyData.length === 0) {
        console.log('No regency data available, using default style');
        return {
            fillColor: '#FED976', // Default color untuk data kosong
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.3
        };
    }
    
    // Mapping langsung: KDPKAB (string) ke regency_id (integer)
    const regencyDataItem = regencyData.find(r => r.regency_id == parseInt(geoJsonRegencyId));
    const masterRegency = allRegencies.find(r => r.regency_id == parseInt(geoJsonRegencyId));
    const regencyName = regencyDataItem ? regencyDataItem.regency_name : (masterRegency ? masterRegency.regency_name : feature.properties.WADMKK);
    
    console.log('Styling regency:', geoJsonRegencyId, regencyName);
    console.log('Found regency data:', regencyDataItem);
    
    const count = regencyDataItem ? regencyDataItem.total_products : 0;
    console.log('Count for regency:', count);
    
    return {
        fillColor: getColor(count),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    };
}

// Fungsi untuk highlight pada klik
function highlightFeature(e) {
    const layer = e.target;
    
    if (currentLevel === 'province') {
        // Reset semua layer ke style default dengan warna sesuai data
        window.geojson.eachLayer(function(l) {
            const geoJsonProvinceId = l.feature.properties.KODE_PROV;
            
            // Cek apakah data ada
            if (!provinceData || provinceData.length === 0) {
                l.setStyle({
                    fillColor: '#FED976',
                    weight: 2,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.3
                });
            } else {
                const provinceDataItem = provinceData.find(p => p.province_id == parseInt(geoJsonProvinceId));
                const count = provinceDataItem ? provinceDataItem.total_products : 0;
                
                l.setStyle({
                    fillColor: getColor(count),
                    weight: 2,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.7
                });
            }
        });
        
        // Highlight layer yang diklik
        layer.setStyle({
            weight: 5,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });
        
        // Tampilkan detail provinsi menggunakan fungsi yang sudah dibuat
        const geoJsonProvinceId = layer.feature.properties.KODE_PROV;
        updateProvinceDetail(parseInt(geoJsonProvinceId));
        
        // Update filter dropdown untuk menyesuaikan dengan provinsi yang diklik
        isProgrammaticChange = true;
        document.getElementById('province_id').value = geoJsonProvinceId;
    } else if (currentLevel === 'regency') {
        // Reset semua layer ke style default dengan warna sesuai data
        window.geojson.eachLayer(function(l) {
            const geoJsonRegencyId = l.feature.properties.KDPKAB;
            
            // Cek apakah data ada
            if (!regencyData || regencyData.length === 0) {
                l.setStyle({
                    fillColor: '#FED976',
                    weight: 2,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.3
                });
            } else {
                const regencyDataItem = regencyData.find(r => r.regency_id == parseInt(geoJsonRegencyId));
                const count = regencyDataItem ? regencyDataItem.total_products : 0;
            
                l.setStyle({
                    fillColor: getColor(count),
                    weight: 2,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.7
                });
            }
        });
        
        // Highlight layer yang diklik
        layer.setStyle({
            weight: 5,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });
        
        // Tampilkan detail kabupaten/kota
        const geoJsonRegencyId = layer.feature.properties.KDPKAB;
        
        // Mapping langsung: KDPKAB (string) ke regency_id (integer)
        const regencyDataItem = regencyData.find(r => r.regency_id == parseInt(geoJsonRegencyId));
        const regencyProductsData = regencyProducts[parseInt(geoJsonRegencyId)] || [];
        
        const masterRegency = allRegencies.find(r => r.regency_id == parseInt(geoJsonRegencyId));
        const regencyName = regencyDataItem ? regencyDataItem.regency_name : (masterRegency ? masterRegency.regency_name : layer.feature.properties.WADMKK);
        let detailHtml = `<h6>Detail Kabupaten/Kota: ${regencyName}</h6>`;
        
        if (regencyDataItem) {
            detailHtml += `
                <p><strong>Total Produk:</strong> ${regencyDataItem.total_products}</p>
                <p><strong>Total Nilai:</strong> Rp ${parseFloat(regencyDataItem.total_value).toLocaleString()}</p>
            `;
            
            if (regencyProductsData.length > 0) {
                detailHtml += '<h6>Produk yang Terjual:</h6><ul>';
                regencyProductsData.forEach(product => {
                    detailHtml += `<li>${product.product_name} (${product.total_quantity} ${product.unit})</li>`;
                });
                detailHtml += '</ul>';
            }
        } else {
            // Cek apakah kabupaten/kota ada di master data
            const masterRegency = allRegencies.find(r => r.regency_id == parseInt(geoJsonRegencyId));
            if (masterRegency) {
                detailHtml += `
                    <p><strong>Total Produk:</strong> 0</p>
                    <p><strong>Total Nilai:</strong> Rp 0</p>
                    <p class="text-muted">Belum ada transaksi di kabupaten/kota ini</p>
                `;
            } else {
                detailHtml += '<p class="text-muted">Data kabupaten/kota tidak ditemukan</p>';
            }
        }
        
        document.getElementById('province-detail').innerHTML = detailHtml;
    }
}

// Fungsi untuk load data kabupaten/kota
function loadRegencyData(provinceId) {
    console.log('Loading regency data for province:', provinceId);
    
    // Filter regency data berdasarkan province_id
    const filteredRegencyData = regencyData.filter(r => r.province_id == provinceId);
    console.log('Filtered regency data:', filteredRegencyData);
    
    // Load GeoJSON kabupaten/kota (selalu tampilkan meskipun tidak ada data transaksi)
    fetch('/regencies.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Regency GeoJSON loaded successfully:', data);
            
            // Filter GeoJSON untuk provinsi yang dipilih
            const filteredFeatures = data.features.filter(feature => {
                const kdpPum = feature.properties.KDPPUM;
                return kdpPum === provinceId.toString();
            });
            
            console.log('Filtered features for province', provinceId, ':', filteredFeatures);
            
            const filteredGeoJSON = {
                type: "FeatureCollection",
                features: filteredFeatures
            };
            
            // Hapus GeoJSON provinsi yang ada
            if (window.geojson) {
                map.removeLayer(window.geojson);
            }
            
            // Tambahkan GeoJSON kabupaten/kota
            currentLevel = 'regency';
            window.geojson = L.geoJson(filteredGeoJSON, {
                style: styleRegency,
                onEachFeature: onEachFeature
            }).addTo(map);
            
            // Update legend
            updateLegend('regency');
            
            // Update detail panel dengan daftar kota/kabupaten
            updateDetailPanelWithRegencyList('regency', filteredRegencyData, provinceId);
            
            // Tampilkan tombol kembali
            document.getElementById('back-to-provinces').style.display = 'inline-block';
        })
        .catch(error => {
            console.error('Error loading regency GeoJSON:', error);
        });
}

// Fungsi untuk zoom ke provinsi atau kabupaten/kota
function zoomToFeature(e) {
    if (currentLevel === 'province') {
        // Zoom ke provinsi terlebih dahulu
        map.fitBounds(e.target.getBounds());
        
        // Load data kabupaten/kota langsung
        const geoJsonProvinceId = e.target.feature.properties.KODE_PROV;
        currentProvinceId = parseInt(geoJsonProvinceId);
        loadRegencyData(currentProvinceId);
    } else if (currentLevel === 'regency') {
        // Zoom ke kabupaten/kota
        map.fitBounds(e.target.getBounds());
    }
}

// Fungsi untuk update legend
function updateLegend(level) {
    // Hapus legend yang ada
    const existingLegend = document.querySelector('.legend');
    if (existingLegend) {
        existingLegend.remove();
    }
    
    // Buat legend baru
    const legend = L.control({position: 'bottomright'});
    
    legend.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'info legend');
        const grades = [0, 2, 4, 6, 8, 10];
        
        const title = level === 'regency' ? 'Jumlah Produk (Kabupaten/Kota)' : 'Jumlah Produk (Provinsi)';
        div.innerHTML = `<h4>${title}</h4>`;
        
        for (let i = 0; i < grades.length; i++) {
            div.innerHTML +=
                '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
        }
        
        return div;
    };
    
    legend.addTo(map);
}

// Fungsi untuk kembali ke view provinsi
function backToProvinces() {
    // Set view ke seluruh Indonesia dengan zoom yang lebih dekat
    map.setView([-2.548926, 118.014863], 5);
    
    // Pastikan batasan area Indonesia tetap aktif
    map.setMaxBounds([
        [-11.0, 95.0], // Southwest bounds (Lat, Lng)
        [6.0, 141.0]   // Northeast bounds (Lat, Lng)
    ]);
    
    // Reload GeoJSON provinsi untuk memastikan tampil dengan benar
    reloadProvinceGeoJSON();
    
    // Reset detail panel tanpa mereset filter
    document.getElementById('province-detail').innerHTML = '<p class="text-muted">Klik pada provinsi untuk melihat detail</p>';
    document.getElementById('back-to-provinces').style.display = 'none';
}

// Fungsi untuk update detail panel
function updateDetailPanel(level, data) {
    const detailPanel = document.getElementById('province-detail');
    
    if (level === 'regency') {
        const totalRegencies = data.length;
        const totalProducts = data.reduce((sum, item) => sum + item.total_products, 0);
        const totalValue = data.reduce((sum, item) => sum + item.total_value, 0);
        
        // Dapatkan nama provinsi dari currentProvinceId
        const currentProvince = allProvinces[currentProvinceId];
        const provinceName = currentProvince ? currentProvince.province_name : `Provinsi ID ${currentProvinceId}`;
        
        let detailHtml = `
            <h6>Kabupaten/Kota di Provinsi: ${provinceName}</h6>
            <p><strong>Total Kabupaten/Kota dengan Transaksi:</strong> ${totalRegencies}</p>
            <p><strong>Total Produk:</strong> ${totalProducts}</p>
            <p><strong>Total Nilai:</strong> Rp ${parseFloat(totalValue).toLocaleString()}</p>
            <hr>
            <p class="text-muted">Klik pada kabupaten/kota untuk melihat detail</p>
        `;
        
        detailPanel.innerHTML = detailHtml;
        
        // Tampilkan tombol kembali
        document.getElementById('back-to-provinces').style.display = 'inline-block';
    }
}

// Fungsi untuk update filter produk berdasarkan plant type
function updateProductFilter() {
    const plantTypeSelect = document.getElementById('plant_type_id');
    const productSelect = document.getElementById('product_id');
    const selectedPlantType = plantTypeSelect.value;
    
    // Simpan nilai produk yang sedang dipilih (jika ada)
    const currentSelectedProduct = productSelect.value;
    
    // Reset produk filter
    productSelect.innerHTML = '<option value="">Pilih Jenis Tanaman terlebih dahulu</option>';
    
    if (selectedPlantType) {
        // Enable filter produk
        productSelect.disabled = false;
        
        // Filter produk berdasarkan plant type yang dipilih
        const filteredProducts = allProducts.filter(product => 
            product.plant_type_id == parseInt(selectedPlantType)
        );
        
        // Tambahkan opsi "Semua Produk"
        productSelect.innerHTML = '<option value="">Semua Produk</option>';
        
        // Tambahkan produk yang sesuai
        filteredProducts.forEach(product => {
            const option = document.createElement('option');
            option.value = product.product_id;
            option.textContent = product.product_name;
            productSelect.appendChild(option);
        });
        
        // Coba kembalikan nilai yang dipilih sebelumnya (jika masih valid)
        if (currentSelectedProduct && filteredProducts.some(p => p.product_id == parseInt(currentSelectedProduct))) {
            productSelect.value = currentSelectedProduct;
        }
        
        console.log('Updated product filter for plant type:', selectedPlantType, 'Products:', filteredProducts);
        console.log('Restored selected product:', currentSelectedProduct);
    } else {
        // Disable filter produk
        productSelect.disabled = true;
        productSelect.innerHTML = '<option value="">Pilih Jenis Tanaman terlebih dahulu</option>';
    }
}

// Fungsi untuk reload GeoJSON provinsi
function reloadProvinceGeoJSON() {
    fetch('/provinces.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Reloading province GeoJSON:', data);
            
            // Hapus GeoJSON yang ada
            if (window.geojson) {
                map.removeLayer(window.geojson);
            }
            
            // Tambahkan GeoJSON provinsi baru
            currentLevel = 'province';
            window.geojson = L.geoJson(data, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(map);
            
            // Update legend
            updateLegend('province');
            
            // Reset detail panel
            document.getElementById('province-detail').innerHTML = '<p class="text-muted">Klik pada provinsi untuk melihat detail</p>';
            document.getElementById('back-to-provinces').style.display = 'none';
        })
        .catch(error => {
            console.error('Error reloading province GeoJSON:', error);
        });
}

// Fungsi untuk load GeoJSON regency
function loadRegencyGeoJSON(provinceId) {
    fetch('/regencies.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Loading regency GeoJSON:', data);
            
            // Filter regency berdasarkan province_id
            const filteredRegencies = data.features.filter(feature => {
                const regencyProvinceId = feature.properties.KDPPUM;
                return regencyProvinceId === provinceId.toString();
            });
            
            console.log('Filtered regencies for province', provinceId, ':', filteredRegencies);
            
            // Buat GeoJSON baru dengan regency yang difilter
            const filteredGeoJSON = {
                type: "FeatureCollection",
                features: filteredRegencies
            };
            
            // Hapus GeoJSON yang ada
            if (window.geojson) {
                map.removeLayer(window.geojson);
            }
            
            // Tambahkan GeoJSON regency
            currentLevel = 'regency';
            window.geojson = L.geoJson(filteredGeoJSON, {
                style: styleRegency,
                onEachFeature: onEachFeature
            }).addTo(map);
            
            // Update legend
            updateLegend('regency');
            
            // Update detail panel dengan daftar regency
            updateDetailPanelWithRegencyList('regency', regencyData.filter(r => r.province_id == parseInt(provinceId)), provinceId);
            
            // Tampilkan tombol kembali
            document.getElementById('back-to-provinces').style.display = 'inline-block';
        })
        .catch(error => {
            console.error('Error loading regency GeoJSON:', error);
        });
}

// Fungsi untuk zoom out ke seluruh Indonesia
function zoomOutToIndonesia(resetFilters = false) {
    // Set view ke seluruh Indonesia dengan zoom yang lebih dekat
    map.setView([-2.548926, 118.014863], 5);
    
    // Pastikan batasan area Indonesia tetap aktif
    map.setMaxBounds([
        [-11.0, 95.0], // Southwest bounds (Lat, Lng)
        [6.0, 141.0]   // Northeast bounds (Lat, Lng)
    ]);
    
    // Reload GeoJSON provinsi untuk memastikan tampil dengan benar
    reloadProvinceGeoJSON();
    
    // Reset filter hanya jika diminta
    if (resetFilters) {
        isProgrammaticChange = true;
        document.getElementById('province_id').value = '';
        document.getElementById('plant_type_id').value = '';
        document.getElementById('product_id').value = '';
        updateProductFilter();
    }
}

// Fungsi untuk update detail panel dengan daftar kota/kabupaten
function updateDetailPanelWithRegencyList(level, data, provinceId) {
    const detailPanel = document.getElementById('province-detail');
    
    if (level === 'regency') {
        const totalRegencies = data.length;
        const totalProducts = data.reduce((sum, item) => sum + item.total_products, 0);
        const totalValue = data.reduce((sum, item) => sum + item.total_value, 0);
        
        // Dapatkan nama provinsi dari currentProvinceId
        const currentProvince = allProvinces[currentProvinceId];
        const provinceName = currentProvince ? currentProvince.province_name : `Provinsi ID ${currentProvinceId}`;
        
        let detailHtml = `
            <h6>Kabupaten/Kota di Provinsi: ${provinceName}</h6>
            <p><strong>Total Kabupaten/Kota dengan Transaksi:</strong> ${totalRegencies}</p>
            <p><strong>Total Produk:</strong> ${totalProducts}</p>
            <p><strong>Total Nilai:</strong> Rp ${parseFloat(totalValue).toLocaleString()}</p>
        `;
        
        // Tambahkan daftar kota/kabupaten di provinsi ini
        const regenciesInProvince = allRegencies.filter(r => {
            const regencyProvinceId = parseInt(r.province_id);
            const searchProvinceId = parseInt(provinceId);
            return regencyProvinceId == searchProvinceId;
        });
        
        if (regenciesInProvince.length > 0) {
            detailHtml += '<hr><h6>Daftar Kota/Kabupaten di Provinsi ini:</h6>';
            
            // Tambahkan informasi filter jika ada
            const selectedPlantType = document.getElementById('plant_type_id').value;
            if (selectedPlantType) {
                const plantTypeSelect = document.getElementById('plant_type_id');
                const selectedOption = plantTypeSelect.options[plantTypeSelect.selectedIndex];
                detailHtml += `<small class="text-muted mb-2 d-block">* Data ditampilkan sesuai filter: ${selectedOption.text}</small>`;
            }
            
            detailHtml += '<div style="max-height: 200px; overflow-y: auto;">';
            
            regenciesInProvince.forEach(regency => {
                // Cari data transaksi untuk regency ini (mungkin terfilter)
                const regencyDataItem = regencyData.find(r => r.regency_id == regency.regency_id);
                const regencyProductsData = regencyProducts[regency.regency_id] || [];
                
                detailHtml += `<div class="mb-2 p-2 border rounded">`;
                detailHtml += `<strong>${regency.regency_name}</strong>`;
                
                if (regencyDataItem) {
                    detailHtml += `<br><small class="text-success">Total Produk: ${regencyDataItem.total_products} | Total Nilai: Rp ${parseFloat(regencyDataItem.total_value).toLocaleString()}</small>`;
                    
                    if (regencyProductsData.length > 0) {
                        detailHtml += '<br><small class="text-muted">Produk: ';
                        const productNames = regencyProductsData.map(p => `${p.product_name} (${p.total_quantity} ${p.unit})`);
                        detailHtml += productNames.join(', ');
                        detailHtml += '</small>';
                    }
                } else {
                    detailHtml += `<br><small class="text-muted">Belum ada transaksi</small>`;
                }
                
                detailHtml += `</div>`;
            });
            
            detailHtml += '</div>';
        }
        
        detailHtml += '<hr><p class="text-muted">Klik pada kabupaten/kota untuk melihat detail</p>';
        
        detailPanel.innerHTML = detailHtml;
        
        // Tampilkan tombol kembali
        document.getElementById('back-to-provinces').style.display = 'inline-block';
    }
}

// Event listener untuk tombol kembali dan filter
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('back-to-provinces').addEventListener('click', backToProvinces);
    
    // Auto submit untuk filter
    const provinceSelect = document.getElementById('province_id');
    const plantTypeSelect = document.getElementById('plant_type_id');
    
    // Auto submit untuk plant type filter (tanpa reset produk jika plant type sama)
    let previousPlantType = plantTypeSelect.value;
    plantTypeSelect.addEventListener('change', function() {
        const currentPlantType = this.value;
        
        // Hanya update filter produk jika plant type berubah
        if (previousPlantType !== currentPlantType) {
            updateProductFilter();
            previousPlantType = currentPlantType;
        }
        
        // Update ringkasan distribusi jika ada plant type yang dipilih
        if (currentPlantType) {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption) {
                updateDistributionSummary(currentPlantType, selectedOption.text);
            }
        }
        
        // Reload GeoJSON untuk memastikan tampil dengan benar
        reloadProvinceGeoJSON();
        
        // Submit form setelah delay kecil untuk memastikan filter produk sudah diupdate
        setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 100);
    });
    
    // Event listener untuk form submit
    document.getElementById('filterForm').addEventListener('submit', function() {
        // Reload GeoJSON untuk memastikan tampil dengan benar
        reloadProvinceGeoJSON();
    });
    
    // Inisialisasi filter produk saat halaman dimuat
    updateProductFilter();
    
    // Pastikan nilai yang dipilih dari server tetap terpilih
    const selectedProduct = '{{ $selectedProduct }}';
    if (selectedProduct) {
        const productSelect = document.getElementById('product_id');
        if (productSelect.value !== selectedProduct) {
            productSelect.value = selectedProduct;
        }
    }
    
    // Update ringkasan distribusi jika ada filter jenis tanaman
    const selectedPlantType = '{{ $selectedPlantType }}';
    if (selectedPlantType) {
        const plantTypeSelect = document.getElementById('plant_type_id');
        const selectedOption = plantTypeSelect.options[plantTypeSelect.selectedIndex];
        if (selectedOption) {
            updateDistributionSummary(selectedPlantType, selectedOption.text);
        }
    }
    
    // Event listener untuk tombol tampilkan peta regency
    document.getElementById('show-regency-map').addEventListener('click', function() {
        if (currentProvinceId) {
            loadRegencyData(currentProvinceId);
        }
    });
    
    // Event listener untuk filter produk
    document.getElementById('product_id').addEventListener('change', function() {
        // Reload GeoJSON untuk memastikan tampil dengan benar
        reloadProvinceGeoJSON();
        
        // Submit form setelah delay kecil
        setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 100);
    });
    
    // Special handling untuk province filter
    let isProgrammaticChange = false; // Flag untuk mencegah infinite loop
    
    provinceSelect.addEventListener('change', function() {
        if (isProgrammaticChange) {
            isProgrammaticChange = false;
            return;
        }
        
        const selectedProvinceId = this.value;
        
        if (selectedProvinceId) {
            // Zoom ke provinsi terlepas dari ada transaksi atau tidak
            const provinceFeature = findProvinceFeature(selectedProvinceId);
            if (provinceFeature) {
                map.fitBounds(provinceFeature.getBounds());
                currentProvinceId = parseInt(selectedProvinceId);
                
                // Update detail panel untuk provinsi yang dipilih
                updateProvinceDetail(selectedProvinceId);
                
                // Load regency data jika ada
                const provinceDataItem = provinceData.find(p => p.province_id == parseInt(selectedProvinceId));
                if (provinceDataItem) {
                    loadRegencyData(currentProvinceId);
                }
            }
        } else {
            // Jika "Semua Provinsi" dipilih, zoom out ke seluruh Indonesia tanpa reset filter
            zoomOutToIndonesia(false);
        }
    });
});

// Fungsi untuk mencari feature provinsi berdasarkan ID
function findProvinceFeature(provinceId) {
    if (window.geojson && currentLevel === 'province') {
        let foundFeature = null;
        window.geojson.eachLayer(function(layer) {
            if (layer.feature.properties.KODE_PROV === provinceId.toString()) {
                foundFeature = layer;
            }
        });
        return foundFeature;
    }
    return null;
}

// Fungsi untuk generate ringkasan distribusi berdasarkan jenis tanaman
function generateDistributionSummary(plantTypeId, plantTypeName) {
    console.log('Generating distribution summary for plant type:', plantTypeId, plantTypeName);
    
    // Filter provinsi yang memiliki transaksi untuk jenis tanaman ini
    const provincesWithTransactions = provinceData.filter(province => {
        const provinceProductsData = provinceProducts[province.province_id] || [];
        return provinceProductsData.some(product => product.plant_type_id == parseInt(plantTypeId));
    });
    
    if (provincesWithTransactions.length === 0) {
        return '<p class="text-muted">Belum ada transaksi untuk jenis tanaman ini</p>';
    }
    
    let summaryHtml = '<div style="max-height: 300px; overflow-y: auto;">';
    
    // Daftar provinsi yang membeli jenis tanaman ini
    summaryHtml += '<h6 class="text-primary">Provinsi yang Membeli ' + plantTypeName + ':</h6>';
    summaryHtml += '<ul class="list-unstyled">';
    
    provincesWithTransactions.forEach(province => {
        const provinceProductsData = provinceProducts[province.province_id] || [];
        const plantTypeProducts = provinceProductsData.filter(product => 
            product.plant_type_id == parseInt(plantTypeId)
        );
        
        summaryHtml += '<li class="mb-2 p-2 border rounded">';
        summaryHtml += '<strong>' + province.province_name + '</strong>';
        
        if (plantTypeProducts.length > 0) {
            summaryHtml += '<br><small class="text-success">Produk: ';
            const productNames = plantTypeProducts.map(p => p.product_name + ' (' + p.total_quantity + ' ' + p.unit + ')');
            summaryHtml += productNames.join(', ');
            summaryHtml += '</small>';
        }
        
        // Cari kabupaten/kota dalam provinsi ini yang membeli jenis tanaman ini
        const regenciesInProvince = allRegencies.filter(r => r.province_id == province.province_id);
        const regenciesWithTransactions = regenciesInProvince.filter(regency => {
            const regencyProductsData = regencyProducts[regency.regency_id] || [];
            return regencyProductsData.some(product => product.plant_type_id == parseInt(plantTypeId));
        });
        
        if (regenciesWithTransactions.length > 0) {
            summaryHtml += '<br><small class="text-info">Kabupaten/Kota: ';
            const regencyNames = regenciesWithTransactions.map(r => r.regency_name);
            summaryHtml += regencyNames.join(', ');
            summaryHtml += '</small>';
        }
        
        summaryHtml += '</li>';
    });
    
    summaryHtml += '</ul>';
    
    // Statistik ringkasan
    const totalProvinces = provincesWithTransactions.length;
    const totalRegencies = regencyData.filter(regency => {
        const regencyProductsData = regencyProducts[regency.regency_id] || [];
        return regencyProductsData.some(product => product.plant_type_id == parseInt(plantTypeId));
    }).length;
    
    summaryHtml += '<hr><div class="row">';
    summaryHtml += '<div class="col-6"><small class="text-muted">Total Provinsi: <strong>' + totalProvinces + '</strong></small></div>';
    summaryHtml += '<div class="col-6"><small class="text-muted">Total Kabupaten/Kota: <strong>' + totalRegencies + '</strong></small></div>';
    summaryHtml += '</div>';
    
    summaryHtml += '</div>';
    
    console.log('Distribution summary generated:', {
        plantTypeId: plantTypeId,
        plantTypeName: plantTypeName,
        provincesWithTransactions: provincesWithTransactions.length,
        totalRegencies: totalRegencies
    });
    
    return summaryHtml;
}

// Fungsi untuk update ringkasan distribusi di panel utama
function updateDistributionSummary(plantTypeId, plantTypeName) {
    const summaryContainer = document.getElementById('distribution-summary');
    if (!summaryContainer) return;
    
    const summaryHtml = generateDistributionSummary(plantTypeId, plantTypeName);
    const cardBody = summaryContainer.querySelector('.card-body');
    if (cardBody) {
        cardBody.innerHTML = summaryHtml;
    }
}

// Fungsi untuk update detail provinsi
function updateProvinceDetail(provinceId) {
    const geoJsonProvinceId = provinceId.toString();
    
    // Mapping langsung: KODE_PROV (string) ke province_id (integer)
    const provinceDataItem = provinceData.find(p => p.province_id == parseInt(geoJsonProvinceId));
    const masterProvince = allProvinces[parseInt(geoJsonProvinceId)];
    const provinceName = provinceDataItem ? provinceDataItem.province_name : (masterProvince ? masterProvince.province_name : `Provinsi ID ${provinceId}`);
    
    console.log('Updating province detail for:', geoJsonProvinceId, provinceName);
    console.log('Master Province:', masterProvince);
    console.log('Province Data Item:', provinceDataItem);
    
    const provinceProductsData = provinceProducts[parseInt(geoJsonProvinceId)] || [];
    
    let detailHtml = `<h6>Detail Provinsi: ${provinceName}</h6>`;
    
    if (provinceDataItem) {
        console.log('Province Data Item:', provinceDataItem);
        console.log('Total Value Raw:', provinceDataItem.total_value);
        console.log('Total Value Type:', typeof provinceDataItem.total_value);
        detailHtml += `
            <p><strong>Total Produk:</strong> ${provinceDataItem.total_products}</p>
            <p><strong>Total Nilai:</strong> Rp ${parseFloat(provinceDataItem.total_value).toLocaleString()}</p>
        `;
        
        if (provinceProductsData.length > 0) {
            detailHtml += '<h6>Produk yang Terjual:</h6><ul>';
            provinceProductsData.forEach(product => {
                detailHtml += `<li>${product.product_name} (${product.total_quantity} ${product.unit})</li>`;
            });
            detailHtml += '</ul>';
        }
    } else {
        // Cek apakah provinsi ada di master data
        if (masterProvince) {
            detailHtml += `
                <p><strong>Total Produk:</strong> 0</p>
                <p><strong>Total Nilai:</strong> Rp 0</p>
                <p class="text-muted">Belum ada transaksi di provinsi ini</p>
            `;
        } else {
            detailHtml += '<p class="text-muted">Data provinsi tidak ditemukan</p>';
        }
    }
    
    // Tambahkan daftar kota/kabupaten di provinsi ini
    const regenciesInProvince = allRegencies.filter(r => {
        const regencyProvinceId = parseInt(r.province_id);
        const searchProvinceId = parseInt(geoJsonProvinceId);
        console.log(`Comparing: ${regencyProvinceId} (${typeof regencyProvinceId}) == ${searchProvinceId} (${typeof searchProvinceId})`);
        return regencyProvinceId == searchProvinceId;
    });
    console.log('Regencies in Province:', regenciesInProvince);
    console.log('Regency Data:', regencyData);
    console.log('Regency Products:', regencyProducts);
    console.log('Province ID being searched:', parseInt(geoJsonProvinceId));
    console.log('All Regencies:', allRegencies);
    
    console.log('Regencies found for province:', regenciesInProvince.length);
    console.log('Sample regency:', regenciesInProvince[0]);
    if (regenciesInProvince.length > 0) {
        detailHtml += '<hr><h6>Daftar Kota/Kabupaten di Provinsi ini:</h6>';
        
        // Tambahkan informasi filter jika ada
        const selectedPlantType = document.getElementById('plant_type_id').value;
        if (selectedPlantType) {
            const plantTypeSelect = document.getElementById('plant_type_id');
            const selectedOption = plantTypeSelect.options[plantTypeSelect.selectedIndex];
            detailHtml += `<small class="text-muted mb-2 d-block">* Data ditampilkan sesuai filter: ${selectedOption.text}</small>`;
        }
        
        detailHtml += '<div style="max-height: 200px; overflow-y: auto;">';
        
            regenciesInProvince.forEach(regency => {
        // Cari data transaksi untuk regency ini (mungkin terfilter)
        const regencyDataItem = regencyData.find(r => r.regency_id == regency.regency_id);
        const regencyProductsData = regencyProducts[regency.regency_id] || [];
        
        console.log(`Regency ${regency.regency_name}:`, regencyDataItem, regencyProductsData);
        console.log(`Regency ID: ${regency.regency_id}, Type: ${typeof regency.regency_id}`);
        console.log(`Province ID: ${regency.province_id}, Type: ${typeof regency.province_id}`);
            
            detailHtml += `<div class="mb-2 p-2 border rounded">`;
            detailHtml += `<strong>${regency.regency_name}</strong>`;
            
            if (regencyDataItem) {
                detailHtml += `<br><small class="text-success">Total Produk: ${regencyDataItem.total_products} | Total Nilai: Rp ${parseFloat(regencyDataItem.total_value).toLocaleString()}</small>`;
                
                if (regencyProductsData.length > 0) {
                    detailHtml += '<br><small class="text-muted">Produk: ';
                    const productNames = regencyProductsData.map(p => `${p.product_name} (${p.total_quantity} ${p.unit})`);
                    detailHtml += productNames.join(', ');
                    detailHtml += '</small>';
                }
            } else {
                detailHtml += `<br><small class="text-muted">Belum ada transaksi</small>`;
            }
            
            detailHtml += `</div>`;
        });
        
        detailHtml += '</div>';
    }
    
    // Tambahkan tombol untuk menampilkan peta regency
    detailHtml += '<hr><button id="show-regency-map" class="btn btn-sm btn-outline-primary">';
    detailHtml += '<i class="fas fa-map"></i> Tampilkan Peta Kota/Kabupaten';
    detailHtml += '</button>';
    
    // Tambahkan ringkasan distribusi jika ada filter jenis tanaman
    const selectedPlantType = document.getElementById('plant_type_id').value;
    if (selectedPlantType) {
        const plantTypeSelect = document.getElementById('plant_type_id');
        const selectedOption = plantTypeSelect.options[plantTypeSelect.selectedIndex];
        const distributionSummary = generateDistributionSummary(selectedPlantType, selectedOption.text);
        if (distributionSummary) {
            detailHtml += '<hr><h6>Ringkasan Distribusi ' + selectedOption.text + ':</h6>';
            detailHtml += distributionSummary;
        }
    }
    
    document.getElementById('province-detail').innerHTML = detailHtml;
    
    // Tampilkan tombol
    document.getElementById('show-regency-map').style.display = 'inline-block';
}

// Fungsi untuk onEachFeature
function onEachFeature(feature, layer) {
    layer.on({
        click: function(e) {
            highlightFeature(e);
            zoomToFeature(e);
        },
        mouseover: function(e) {
            // Tampilkan tooltip dengan nama dari database
            let tooltipText = '';
            
            if (currentLevel === 'province') {
                const geoJsonProvinceId = feature.properties.KODE_PROV;
                const provinceDataItem = provinceData.find(p => p.province_id == parseInt(geoJsonProvinceId));
                const provinceName = provinceDataItem ? provinceDataItem.province_name : (allProvinces[parseInt(geoJsonProvinceId)] ? allProvinces[parseInt(geoJsonProvinceId)].province_name : feature.properties.PROVINSI);
                tooltipText = provinceName;
            } else if (currentLevel === 'regency') {
                const geoJsonRegencyId = feature.properties.KDPKAB;
                const regencyDataItem = regencyData.find(r => r.regency_id == parseInt(geoJsonRegencyId));
                const masterRegency = allRegencies.find(r => r.regency_id == parseInt(geoJsonRegencyId));
                const regencyName = regencyDataItem ? regencyDataItem.regency_name : (masterRegency ? masterRegency.regency_name : feature.properties.WADMKK);
                tooltipText = regencyName;
            }
            
            layer.bindTooltip(tooltipText, {
                permanent: false,
                direction: 'top',
                className: 'custom-tooltip'
            }).openTooltip();
        },
        mouseout: function(e) {
            layer.closeTooltip();
        }
    });
}
</script>

<style>
.legend {
    background: white;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
}

.legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
}

.legend h4 {
    margin: 0 0 5px;
    color: #777;
}

#province-detail {
    max-height: 300px;
    overflow-y: auto;
}

#province-detail ul {
    margin-bottom: 0;
    padding-left: 20px;
}

#province-detail li {
    margin-bottom: 5px;
}

.card-header {
    background: linear-gradient(135deg, #388E3C, #4CAF50);
    color: white;
    border: none;
}

.card-header h3 {
    margin: 0;
    font-weight: 600;
}

.card-header p {
    margin: 5px 0 0 0;
    opacity: 0.9;
}

.badge {
    font-size: 0.9rem !important;
    padding: 8px 12px !important;
}

#map {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.custom-tooltip {
    background: rgba(0, 0, 0, 0.8);
    color: white;
    border: none;
    border-radius: 4px;
    padding: 6px 10px;
    font-size: 12px;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.custom-tooltip::before {
    border-top-color: rgba(0, 0, 0, 0.8);
}
</style>
@endsection 