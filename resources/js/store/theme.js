import Cookies from 'js-cookie'

const { theme } = window.config

export default {
    namespaced: true,
    state: {
        theme: getTheme(theme),
    },
    getters: {
        theme: state => state.theme,
    },
    mutations: {
        SET_THEME(state, { theme }) {
            state.theme = theme
        }
    },
    actions: {
        setTheme ({ commit }, { theme }) {
            commit('SET_THEME', { theme })
            Cookies.set('theme', theme, { expires: 365 })
        }
    }
}

/**
 * @param  {String} fallback
 * @return {String}
 */
function getTheme (fallback) {
    const locale = document.documentElement.getAttribute('data-theme');

    return locale;
}
