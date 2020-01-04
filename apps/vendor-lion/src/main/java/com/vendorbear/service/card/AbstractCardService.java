package com.vendorbear.service.card;

import com.vendorbear.repository.CardRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public abstract class AbstractCardService {
    protected final CardRepository cardRepository;

    public AbstractCardService(CardRepository cardRepository) {
        this.cardRepository = cardRepository;
    }
}
