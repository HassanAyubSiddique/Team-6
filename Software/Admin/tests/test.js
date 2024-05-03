// Import functions to test
const {
    exportChart,
    updateOrdersChart,
    exportOrdersChart
} = require('../DATA/DATA.js'); // Replace with the path to your script file

// Mock document elements and XMLHttpRequest
document.createElement = jest.fn(() => ({
    href: '',
    download: '',
    click: jest.fn()
}));
document.getElementById = jest.fn(() => ({
    value: ''
}));
global.XMLHttpRequest = jest.fn(() => ({
    open: jest.fn(),
    send: jest.fn(),
    status: 200,
    responseText: JSON.stringify({
        labels: [],
        data: []
    })
}));

describe('JavaScript Functions', () => {
    describe('exportChart()', () => {
        test('should create a downloadable image', () => {
            exportChart('testChart', 'TestChart');
            expect(document.createElement).toHaveBeenCalledTimes(1);
        });
    });

    describe('updateOrdersChart()', () => {
        test('should update orders chart', () => {
            updateOrdersChart();
            expect(XMLHttpRequest).toHaveBeenCalledTimes(1);
        });
    });

    describe('exportOrdersChart()', () => {
        test('should create a downloadable image of orders chart', () => {
            exportOrdersChart();
            expect(document.createElement).toHaveBeenCalledTimes(1);
        });
    });
});
