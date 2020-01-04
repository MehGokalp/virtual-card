package com.vendorbear.exception;

import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.ResponseStatus;

@ResponseStatus(value = HttpStatus.NOT_FOUND)
public class CardNotFoundException extends Exception {
    public CardNotFoundException(String cardReference) {
        super("Card not found with given reference:" + cardReference);
    }
}
