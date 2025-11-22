document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initScrollAnimations();
    initPaymentModal();
    initContactForm();
    headerScroll();
});

function initMobileMenu() {
    const mobileToggle = document.getElementById('mobileToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            mobileToggle.classList.toggle('active');
        });
        
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                mobileToggle.classList.remove('active');
            });
        });
    }
}

function headerScroll() {
    const header = document.getElementById('header');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
        } else {
            header.style.boxShadow = '0 4px 6px -1px rgb(0 0 0 / 0.1)';
        }
    });
}

function initScrollAnimations() {
    const animatedElements = document.querySelectorAll('[data-aos]');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('aos-animate');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

function initPaymentModal() {
    const modal = document.getElementById('paymentModal');
    const purchaseButtons = document.querySelectorAll('.btn-purchase');
    const closeButton = document.querySelector('.modal-close');
    const amountFormGroup = document.getElementById('amountFormGroup');
    const customerAmountInput = document.getElementById('customerAmount');
    
    if (!modal || !purchaseButtons.length) return;
    
    purchaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const service = this.getAttribute('data-service');
            const price = this.getAttribute('data-price');
            
            document.getElementById('selectedService').textContent = service;
            document.getElementById('selectedPrice').textContent = price;
            document.getElementById('serviceInput').value = service;
            document.getElementById('amountInput').value = price;
            
            if (amountFormGroup && customerAmountInput) {
                if (service === 'Google Ads' || service === 'Meta Ads') {
                    amountFormGroup.style.display = 'block';
                    customerAmountInput.value = price;
                } else {
                    amountFormGroup.style.display = 'none';
                    customerAmountInput.value = '';
                }
            }
            
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
    });
    
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
    
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
}

function initContactForm() {
    const contactForm = document.getElementById('contactForm');
    
    if (!contactForm) return;
    
    contactForm.addEventListener('submit', function(e) {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const message = document.getElementById('message');
        
        if (name.value.trim() === '') {
            e.preventDefault();
            alert('Please enter your name');
            name.focus();
            return false;
        }
        
        if (!isValidEmail(email.value)) {
            e.preventDefault();
            alert('Please enter a valid email address');
            email.focus();
            return false;
        }
        
        if (message.value.trim() === '') {
            e.preventDefault();
            alert('Please enter your message');
            message.focus();
            return false;
        }
    });
    
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            const name = document.getElementById('customerName');
            const email = document.getElementById('customerEmail');
            const phone = document.getElementById('customerPhone');
            const serviceInput = document.getElementById('serviceInput');
            const customerAmountInput = document.getElementById('customerAmount');
            const amountInput = document.getElementById('amountInput');
            
            if (name.value.trim() === '') {
                e.preventDefault();
                alert('Please enter your name');
                name.focus();
                return false;
            }
            
            if (!isValidEmail(email.value)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                email.focus();
                return false;
            }
            
            if (phone.value.trim() === '') {
                e.preventDefault();
                alert('Please enter your phone number');
                phone.focus();
                return false;
            }

            if (serviceInput && customerAmountInput && (serviceInput.value === 'Google Ads' || serviceInput.value === 'Meta Ads')) {
                const amountValue = parseFloat(customerAmountInput.value);
                if (isNaN(amountValue) || amountValue < 500) {
                    e.preventDefault();
                    alert('Please enter an amount of at least 500 for this service');
                    customerAmountInput.focus();
                    return false;
                }

                if (amountInput) {
                    amountInput.value = amountValue;
                }
            }
        });
    }
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

document.querySelectorAll('a[href^="index.php"]').forEach(link => {
    link.addEventListener('click', function(e) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});

// Simple toast notifications (used for cart actions)
function showToast(message, type = 'success') {
    const existing = document.querySelector('.toast-container');
    let container = existing;

    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = 'toast toast-' + type;

    const icon = document.createElement('span');
    icon.className = 'toast-icon';
    icon.innerHTML = '<i class="fas fa-check-circle"></i>';

    if (type === 'warning') {
        icon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
    }

    const text = document.createElement('span');
    text.className = 'toast-message';
    text.textContent = message;

    toast.appendChild(icon);
    toast.appendChild(text);

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('toast-hide');
        toast.addEventListener('transitionend', () => {
            toast.remove();
        });
    }, 3000);
}
