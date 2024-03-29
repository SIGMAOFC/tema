import Alpine from 'alpinejs';
import '../css/app.css';
import 'iconify-icon';

Alpine.data('data', () => {
    function getThemeFromLocalStorage() {
        // if user already changed the theme, use it
        if (window.localStorage.getItem('dark')) {
            return JSON.parse(window.localStorage.getItem('dark'))
        }

        // else return their preferences
        return (
            true
        )
    }

    function setThemeToLocalStorage(value) {
        window.localStorage.setItem('dark', value)
        window.document.cookie = "theme=" + (value ? 'dark' : 'light');
    }

    return {
        dark: getThemeFromLocalStorage(),
        toggleTheme() {
            this.dark = !this.dark
            setThemeToLocalStorage(this.dark)
        },
        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen
        },
        closeSideMenu() {
            this.isSideMenuOpen = false
        },
        isNotificationsMenuOpen: false,
        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false
        },
        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false
        },
        isPagesMenuOpen: false,
        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen
        },
        isLogsMenuOpen: false,
        toggleLogsMenu() {
            this.isLogsMenuOpen = !this.isLogsMenuOpen
        },
        isManagementMenuOpen: false,
        toggleManagementMenu() {
            this.isManagementMenuOpen = !this.isManagementMenuOpen
        },
        isLanguageMenuOpen: false,
        toggleLanguageMenu() {
            this.isLanguageMenuOpen = !this.isLanguageMenuOpen
        },
        closeLanguageMenu() {
            this.isProfileMenuOpen = false
        },
        // Modal
        isModalOpen: false,
        trapCleanup: null,
        openModal() {
            this.isModalOpen = true
            this.trapCleanup = focusTrap(document.querySelector('#modal'))
        },
        closeModal() {
            this.isModalOpen = false
            this.trapCleanup()
        },
        isRedeemModalOpen: false,
        openRedeemModal() {
            this.isRedeemModalOpen = true
            this.trapCleanup = focusTrap(document.querySelector('#redeem-modal'))
        },
        closeRedeemModal() {
            this.isRedeemModalOpen = false
            this.trapCleanup()
        },
    }
});

window.Alpine = Alpine;

// should be last
Alpine.start();
