<script>
document.addEventListener('DOMContentLoaded', function () {
    const provinceSelect = document.getElementById('province_id');
    const regencySelect = document.getElementById('regency_id');
    const districtSelect = document.getElementById('district_id');

    async function fetchOptions(url, targetSelect, placeholder) {
        targetSelect.innerHTML = `<option value="">${placeholder}</option>`;

        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.data && Array.isArray(result.data)) {
            result.data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name;
                targetSelect.appendChild(option);
            });
        }
    }

    provinceSelect?.addEventListener('change', async function () {
        const provinceId = this.value;

        regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

        if (!provinceId) return;

        await fetchOptions(`{{ route('admin.regions.regencies') }}?province_id=${provinceId}`, regencySelect, 'Pilih Kabupaten/Kota');
    });

    regencySelect?.addEventListener('change', async function () {
        const regencyId = this.value;

        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

        if (!regencyId) return;

        await fetchOptions(`{{ route('admin.regions.districts') }}?regency_id=${regencyId}`, districtSelect, 'Pilih Kecamatan');
    });
});
</script>