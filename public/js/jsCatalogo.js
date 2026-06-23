document.addEventListener("DOMContentLoaded", function() {
    
    // 1. INICIALIZAR EL CALENDARIO TEMATIZADO
    const inputsFechas = document.querySelectorAll('.input-rango-fechas');

    inputsFechas.forEach(input => {
        const fechasBloqueadas = JSON.parse(input.getAttribute('data-ocupadas'));

        flatpickr(input, {
            mode: "range",              
            minDate: "today",           
            dateFormat: "Y-m-d",        
            locale: "es",               
            disable: fechasBloqueadas,  
            showMonths: 1,
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 1) {
                    instance.clear();
                }
            }
        });
    });

    // 2. PREVENIR ENVIOS DE RANGOS INCOMPLETOS
    const formsReserva = document.querySelectorAll('form[action*="alquileres/reservar"]');
    
    formsReserva.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputFecha = form.querySelector('.input-rango-fechas');
            
            if (!inputFecha.value || !inputFecha.value.includes(' a ')) {
                e.preventDefault(); 
                alert("Por favor, selecciona un rango de fechas completo (Día de retiro y Día de devolución) en el calendario.");
            }
        });
    });
});
