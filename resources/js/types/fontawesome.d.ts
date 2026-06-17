// resources/js/types/fontawesome.d.ts

declare module '@vue/runtime-core' {
    export interface GlobalComponents {
        FontAwesomeIcon: typeof import('@fortawesome/vue-fontawesome')['FontAwesomeIcon'];
    }
}

export {};