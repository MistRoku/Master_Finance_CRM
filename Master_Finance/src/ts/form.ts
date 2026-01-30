// Additional form handling, e.g., for dynamic fields
export function addDynamicField(containerId: string, fieldHtml: string) {
    const container = document.getElementById(containerId);
    if (container) {
        container.insertAdjacentHTML('beforeend', fieldHtml);
    }
}
