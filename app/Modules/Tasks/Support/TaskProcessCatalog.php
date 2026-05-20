<?php

namespace App\Modules\Tasks\Support;

class TaskProcessCatalog
{
    /**
     * Task process catalog grouped by main category.
     *
     * @return array<string, array<int, array{name:string, sla_days:int, allow_validity_lead_time:bool}>>
     */
    public static function all(): array
    {
        return [
            'Pre-Sales' => [
                ['name' => 'Product - BOM', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Product - Quotation', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Project - Design - Minor', 'sla_days' => 5, 'allow_validity_lead_time' => false],
                ['name' => 'Project - Design - Major', 'sla_days' => 10, 'allow_validity_lead_time' => false],
                ['name' => 'Project - POC', 'sla_days' => 7, 'allow_validity_lead_time' => false],
                ['name' => 'Project - Proposal/Quotation', 'sla_days' => 5, 'allow_validity_lead_time' => false],
            ],
            'Project/Product Processing' => [
                ['name' => 'Proposal/Quotation - For end-user evaluation', 'sla_days' => 7, 'allow_validity_lead_time' => true],
                ['name' => 'PO', 'sla_days' => 2, 'allow_validity_lead_time' => false],
                ['name' => 'Downpayment - Upon Purchase Order', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Payment - Upon Delivery', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Progress Billing - Upon Delivery', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Payment - Upon User Acceptance', 'sla_days' => 5, 'allow_validity_lead_time' => false],
                ['name' => 'Payment - Upon COC', 'sla_days' => 5, 'allow_validity_lead_time' => false],
                ['name' => 'Sales/Service Invoice', 'sla_days' => 2, 'allow_validity_lead_time' => false],
                ['name' => 'Delivery', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Installation', 'sla_days' => 5, 'allow_validity_lead_time' => false],
                ['name' => 'Commissioning', 'sla_days' => 7, 'allow_validity_lead_time' => false],
                ['name' => 'Sales Order', 'sla_days' => 2, 'allow_validity_lead_time' => false],
                ['name' => 'PO to Supplier', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Payment to Supplier', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Delivery - Partial', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Delivery - Complete', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Sales Invoice', 'sla_days' => 2, 'allow_validity_lead_time' => false],
                ['name' => 'Payment - Downpayment', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Payment - Progress Billing', 'sla_days' => 5, 'allow_validity_lead_time' => false],
                ['name' => 'Payment - Full Payment', 'sla_days' => 5, 'allow_validity_lead_time' => false],
                ['name' => 'Order Confirmation', 'sla_days' => 2, 'allow_validity_lead_time' => false],
            ],
            'After-Sales' => [
                ['name' => 'For COC', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'For COA', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'COC', 'sla_days' => 3, 'allow_validity_lead_time' => false],
                ['name' => 'Service / Technical Support', 'sla_days' => 3, 'allow_validity_lead_time' => false],
            ],
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function mainCategories(): array
    {
        return array_keys(self::all());
    }

    /**
     * @return array<int, string>
     */
    public static function specificProcessNamesFor(string $mainCategory): array
    {
        $options = self::all()[$mainCategory] ?? [];

        return array_values(array_map(
            static fn (array $item): string => (string) ($item['name'] ?? ''),
            $options
        ));
    }
}
