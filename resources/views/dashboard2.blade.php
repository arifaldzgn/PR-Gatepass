@extends('layouts.main')

@section('container')
<form action="{{ route('requests.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="request_name" class="form-label">Request Name</label>
        <input type="text" class="form-control" id="request_name" name="request_name" required>
    </div>

    <div class="materials">
        <div class="material mb-3">
            <label for="material_name" class="form-label">Material Name</label>
            <input type="text" class="form-control" name="materials[0][material_name]" required>
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" name="materials[0][quantity]" required>
            <label for="usage" class="form-label">Usage</label>
            <textarea class="form-control" name="materials[0][usage]" required></textarea>
        </div>
    </div>

    <button type="button" class="btn btn-primary" id="addMaterial">Add Material</button>
    <button type="submit" class="btn btn-success">Submit Request</button>
</form>

<script>
    document.getElementById('addMaterial').addEventListener('click', function() {
        const materialsDiv = document.querySelector('.materials');
        const materialCount = materialsDiv.querySelectorAll('.material').length;

        const newMaterial = document.createElement('div');
        newMaterial.classList.add('material', 'mb-3');
        newMaterial.innerHTML = `
            <label for="material_name" class="form-label">Material Name</label>
            <input type="text" class="form-control" name="materials[${materialCount}][material_name]" required>
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" name="materials[${materialCount}][quantity]" required>
            <label for="usage" class="form-label">Usage</label>
            <textarea class="form-control" name="materials[${materialCount}][usage]" required></textarea>
        `;
        materialsDiv.appendChild(newMaterial);
    });
</script>
@endsection