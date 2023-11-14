<x-mail::message>
# Transferência enviada

Você enviou uma transferencia no valor de R$ {{$transaction->originOperation->ammount / 100}}
para {{$transaction->destinationOperation->wallet->user->name}}

</x-mail::message>
