 headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                return;
            }

            const refreshPayload = await response.json();
            const items = refreshPayload.data || [];
            renderNotifications(items);
            updateGlobalNotificationBadge(typeof refreshPayload.unread_count === 'number' ? refreshPayload.unread_count : items.length);
        } catch (error) {
        }
    };

    const markNotificationAsRead = async (notificationId) => {
        if (!notificationId || !payload.notificationReadUrlTemplate) {
            return;
        }

        try {
            const response = await fetch(getNotificationReadUrl(notificationId), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                return;
            }

            const readPayload = await response.json();
            if (typeof readPayload.unread_count === 'number') {
                updateGlobalNotificationBadge(readPayload.unread_count);
            }

            await refreshNotifications();
        } catch (error) {
        }
    };

    const markAllNotificationsAsRead = async () => {
        if (!payload.notificationReadAllUrl) {
            return;
        }

        try {
            const response = await fetch(payload.notificationReadAllUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                return;
            }

            const readPayload = await response.json();
            if (typeof readPayload.unread_count === 'number') {
                updateGlobalNotificationBadge(readPayload.unread_count);
            }

            renderNotifications([]);
        } catch (error) {
        }
    };

    notificationsList?.addEventListener('click', function (event) {
        const target = event.target instanceof Element ? event.target.closest('.advanced-mark-notification-read') : null;
        if (!target) {
            return;
        }

        const item = target.closest('[data-notification-id]');
        const notificationId = item?.getAttribute('data-notification-id');
        if (!notificationId) {
            return;
        }

        markNotificationAsRead(notificationId);
    });

    markAllReadButton?.addEventListener('click', function () {
        markAllNotificationsAsRead();
    });

    const refreshMetrics = async () => {
        if (!payload.metricsUrl) {
            return;
        }

        try {
            const response = await fetch(payload.metricsUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                return;
            }

            const metrics = await response.json();

            if (Array.isArray(metrics.statusCounts)) {
                statusChart.updateSeries(metrics.statusCounts);
            }

            if (Array.isArray(metrics.tasksPerDay) && Array.isArray(metrics.tasksPerDayLabelsFormatted)) {
                lineChart.updateOptions({
                    xaxis: { categories: metrics.tasksPerDayLabelsFormatted }
                });
                lineChart.updateSeries([{ name: 'Tasks Created', data: metrics.tasksPerDay }]);
            }

            const donePct = document.getElementById('advanced-done-percentage');
            const inProgressPct = document.getElementById('advanced-in-progress-percentage');

            if (donePct && typeof metrics.donePercentage === 'number') {
                donePct.textContent = `${metrics.donePercentage}%`;
            }

            if (inProgressPct && typeof metrics.inProgressPercentage === 'number') {
                inProgressPct.textContent = `${metrics.inProgressPercentage}%`;
            }
        } catch (error) {
        }
    };

    setInterval(refreshNotifications, 15000);
    setInterval(refreshMetrics, 15000);
});
</script>
<?php $__env->stopSection(); ?>

<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\dashboard-advanced.blade.php ENDPATH**/ ?>