document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('maintenanceModal')
    const openBtn = document.getElementById('btnOpenMaintenanceModal')
    const closeBtns = document.querySelectorAll('.btnCloseModal')

    if (!modal || !openBtn) return

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden')
        modal.classList.add('flex')
    })

    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => closeModal())
    })

    modal.addEventListener('click', e => {
        if (e.target === modal) closeModal()
    })

    function closeModal() {
        modal.classList.add('hidden')
        modal.classList.remove('flex')
    }
})
