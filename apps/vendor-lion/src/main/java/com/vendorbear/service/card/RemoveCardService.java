package com.vendorbear.service.card;

import com.vendorbear.entitiy.Card;
import com.vendorbear.repository.CardRepository;
import org.springframework.stereotype.Service;

@Service
public class RemoveCardService extends AbstractCardService {
    public RemoveCardService(CardRepository cardRepository) {
        super(cardRepository);
    }

    public Card delete() {
        return new Card();
    }
}
