<?php


function getRole($value): string
{
    $role =  str_replace(['[', '"', ']'], '', $value->pluck('description'));

    return empty($role) ? 'Sem função' : $role;
}

function formatCPF($cpf): string
{
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

function formatCNPJ($cnpj): string
{
    return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
}

function formatCpfCnpj(string $value): string
{
    $numbers = preg_replace('/\D/', '', $value);

    if (strlen($numbers) == 11) {
        return preg_replace(
            '/(\d{3})(\d{3})(\d{3})(\d{2})/',
            '$1.$2.$3-$4',
            $numbers
        );
    }

    if (strlen($numbers) == 14) {
        return preg_replace(
            '/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/',
            '$1.$2.$3/$4-$5',
            $numbers
        );
    }

    return $value;
}

function formatCNS($cns): string
{
    return preg_replace('/(\d{3})(\d{4})(\d{4})(\d{4})/', '$1.$2.$3.$4', $cns);
}

function formatCEP($cep): string
{
    return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $cep);
}

function formatPhone($phone): ?string
{
    if (strlen($phone) === 10) {
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $phone);
    } elseif (strlen($phone) === 11) {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
    }

    return $phone;
}

function formatDate($date): string
{
    return date('d/m/Y', strtotime($date));
}

function formatHour($hour): string
{
    return substr($hour, 0, 5);
}
