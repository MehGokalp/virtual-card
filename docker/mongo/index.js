db.createCollection('virtual_card');

db.vendor_logs.createIndex({
    process_id: 1
}, {
    name: 'vendor_logs_pid_idx'
});

db.vendor_logs.createIndex({
    service: 1
}, {
    name: 'vendor_logs_service_idx'
});

db.currency_provider_logs.createIndex({
    service: 1
}, {
    name: 'vendor_logs_service_idx'
});
