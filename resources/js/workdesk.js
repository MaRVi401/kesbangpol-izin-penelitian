document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('penandatangan-select')) {
            const uuid = e.target.dataset.uuid;
            const val = e.target.value;
            
            const docActions = document.getElementById(`doc-actions-${uuid}`);
            const btnDocx = document.getElementById(`btn-docx-${uuid}`);
            const btnPdf = document.getElementById(`btn-pdf-${uuid}`);
            
            if (val) {
                docActions.classList.remove('hidden');
                docActions.classList.add('flex');
                
                btnDocx.href = `${btnDocx.dataset.baseUrl}?penandatangan_id=${val}`;
                btnPdf.href = `${btnPdf.dataset.baseUrl}?penandatangan_id=${val}`;
            } else {
                docActions.classList.add('hidden');
                docActions.classList.remove('flex');
            }
        }
    });
});