<?php

namespace Venture\Blueprint\Filament\Clusters\Documentation;

use BackedEnum;
use Filament\Clusters\Cluster;

class DocumentationCluster extends Cluster
{
    protected static string | BackedEnum | null $navigationIcon = 'lucide-book-user';
}
