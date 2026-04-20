import { Link } from '@inertiajs/react';
import { ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight } from 'lucide-react';

import { Button } from '@/components/ui/button';
import type { PaginationMeta } from '@/types/ui';
import { cn } from '@/lib/utils';

interface PaginationProps {
    pagination: PaginationMeta;
    baseUrl: string;
    queryParams?: Record<string, string | number | undefined>;
    className?: string;
}

function buildUrl(baseUrl: string, page: number, queryParams?: Record<string, string | number | undefined>): string {
    const params = new URLSearchParams();
    params.set('page', String(page));
    if (queryParams) {
        for (const [key, value] of Object.entries(queryParams)) {
            if (value !== undefined && value !== '') {
                params.set(key, String(value));
            }
        }
    }
    return `${baseUrl}?${params.toString()}`;
}

function getVisiblePages(current: number, last: number): (number | '...')[] {
    if (last <= 7) {
        return Array.from({ length: last }, (_, i) => i + 1);
    }

    const pages: (number | '...')[] = [1];

    if (current > 3) {
        pages.push('...');
    }

    const start = Math.max(2, current - 1);
    const end = Math.min(last - 1, current + 1);

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }

    if (current < last - 2) {
        pages.push('...');
    }

    pages.push(last);
    return pages;
}

export default function Pagination({ pagination, baseUrl, queryParams, className }: PaginationProps) {
    const { current_page, last_page, total } = pagination;

    if (last_page <= 1) return null;

    const pages = getVisiblePages(current_page, last_page);

    return (
        <nav
            aria-label="Pagination"
            className={cn('flex items-center justify-between gap-4', className)}
        >
            <p className="text-muted-foreground text-sm">
                Pahina {current_page} ng {last_page} &middot; {total} na resulta
            </p>

            <div className="flex items-center gap-1">
                {/* First */}
                <Button variant="outline" size="icon" className="size-8" asChild disabled={current_page === 1}>
                    <Link href={buildUrl(baseUrl, 1, queryParams)} preserveState preserveScroll>
                        <ChevronsLeft className="size-4" />
                    </Link>
                </Button>

                {/* Previous */}
                <Button variant="outline" size="icon" className="size-8" asChild disabled={current_page === 1}>
                    <Link href={buildUrl(baseUrl, Math.max(1, current_page - 1), queryParams)} preserveState preserveScroll>
                        <ChevronLeft className="size-4" />
                    </Link>
                </Button>

                {/* Page numbers */}
                {pages.map((page, idx) =>
                    page === '...' ? (
                        <span key={`ellipsis-${idx}`} className="text-muted-foreground px-1 text-sm">
                            &hellip;
                        </span>
                    ) : (
                        <Button
                            key={page}
                            variant={page === current_page ? 'default' : 'outline'}
                            size="icon"
                            className="size-8"
                            asChild={page !== current_page}
                            disabled={page === current_page}
                        >
                            {page === current_page ? (
                                <span>{page}</span>
                            ) : (
                                <Link href={buildUrl(baseUrl, page, queryParams)} preserveState preserveScroll>
                                    {page}
                                </Link>
                            )}
                        </Button>
                    ),
                )}

                {/* Next */}
                <Button variant="outline" size="icon" className="size-8" asChild disabled={current_page === last_page}>
                    <Link href={buildUrl(baseUrl, Math.min(last_page, current_page + 1), queryParams)} preserveState preserveScroll>
                        <ChevronRight className="size-4" />
                    </Link>
                </Button>

                {/* Last */}
                <Button variant="outline" size="icon" className="size-8" asChild disabled={current_page === last_page}>
                    <Link href={buildUrl(baseUrl, last_page, queryParams)} preserveState preserveScroll>
                        <ChevronsRight className="size-4" />
                    </Link>
                </Button>
            </div>
        </nav>
    );
}
