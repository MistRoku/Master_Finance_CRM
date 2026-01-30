// API utilities for mobile app integration
export async function fetchData(endpoint: string, options: RequestInit = {}) {
    const defaultOptions: RequestInit = {
        headers: {
            'X-CSRF-Token': getCsrfToken(),
            'Content-Type': 'application/json'
        }
    };
    return fetch(endpoint, { ...defaultOptions, ...options });
}

function getCsrfToken(): string {
    const meta = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement;
    return meta ? meta.content : '';
}