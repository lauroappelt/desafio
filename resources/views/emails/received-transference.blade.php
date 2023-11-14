<x-mail::message>
# Transferência recebida

Você recebeu uma transferencia no valor de R$ {{$transaction->destinationOperation->ammount / 100}}
de {{$transaction->originOperation->wallet->user->name}}

</x-mail::message>
